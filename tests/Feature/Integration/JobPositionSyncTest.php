<?php

namespace Tests\Feature\Integration;

use App\Jobs\SyncJobPositions;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use App\Services\JobBoards\IndeedJobBoard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class JobPositionSyncTest extends TestCase
{
    use RefreshDatabase;

    private Company $company;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create([
            'name' => 'Test Company',
            'external_id' => 'company_123',
        ]);

        $this->category = Category::factory()->create([
            'name' => 'Development',
        ]);

        Http::fake([
            'api.indeed.com/*' => Http::response($this->getIndeedMockResponse(), 200),
            'api.linkedin.com/*' => Http::response($this->getLinkedInMockResponse(), 200),
        ]);
    }

    #[Test]
    #[Group('sync')]
    public function syncJobsFromMultipleSources(): void
    {
        Queue::fake();

        // Dispatch sync jobs
        SyncJobPositions::dispatch('indeed');
        SyncJobPositions::dispatch('linkedin');

        // Assert jobs were queued
        Queue::assertPushed(SyncJobPositions::class, 2);
    }

    #[Test]
    #[Group('sync')]
    public function syncCreatesNewPositions(): void
    {
        $indeedBoard = new IndeedJobBoard;
        $positions = $indeedBoard->fetch();

        $this->assertCount(2, $positions);
        $this->assertDatabaseCount('job_positions', 2);

        $this->assertDatabaseHas('job_positions', [
            'title' => 'Senior PHP Developer',
            'company_id' => $this->company->id,
            'external_id' => 'indeed_job_123',
            'source' => 'indeed',
        ]);
    }

    #[Test]
    #[Group('sync')]
    public function syncUpdatesExistingPositions(): void
    {
        // Create existing position
        JobPosition::factory()->create([
            'external_id' => 'indeed_job_123',
            'company_id' => $this->company->id,
            'title' => 'Old Title',
            'salary_min' => 70000,
            'source' => 'indeed',
        ]);

        $indeedBoard = new IndeedJobBoard;
        $positions = $indeedBoard->fetch();

        $this->assertDatabaseHas('job_positions', [
            'external_id' => 'indeed_job_123',
            'title' => 'Senior PHP Developer',
            'salary_min' => 80000,
        ]);
    }

    #[Test]
    #[Group('sync')]
    public function syncHandlesDeletedPositions(): void
    {
        // Create positions that no longer exist in source
        JobPosition::factory()->create([
            'external_id' => 'old_job_999',
            'company_id' => $this->company->id,
            'source' => 'indeed',
            'created_at' => now()->subDays(31),
        ]);

        $indeedBoard = new IndeedJobBoard;
        $positions = $indeedBoard->fetch();

        $this->assertDatabaseMissing('job_positions', [
            'external_id' => 'old_job_999',
        ]);
    }

    #[Test]
    #[Group('sync')]
    public function syncHandlesRateLimit(): void
    {
        Http::fake([
            'api.indeed.com/*' => Http::response(['error' => 'Rate limit exceeded'], 429),
        ]);

        $indeedBoard = new IndeedJobBoard;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Rate limit exceeded');

        $indeedBoard->fetch();
    }

    #[Test]
    #[Group('sync')]
    public function syncHandlesInvalidResponse(): void
    {
        Http::fake([
            'api.indeed.com/*' => Http::response(['invalid' => 'data'], 200),
        ]);

        $indeedBoard = new IndeedJobBoard;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response format');

        $indeedBoard->fetch();
    }

    #[Test]
    #[Group('sync')]
    public function syncPreservesApplicationsForUpdatedPositions(): void
    {
        // Create position with applications
        $position = JobPosition::factory()->create([
            'external_id' => 'indeed_job_123',
            'company_id' => $this->company->id,
            'source' => 'indeed',
        ]);

        $position->applications()->create([
            'user_id' => 1,
            'status' => 'pending',
        ]);

        $indeedBoard = new IndeedJobBoard;
        $positions = $indeedBoard->fetch();

        $this->assertDatabaseHas('job_applications', [
            'job_position_id' => $position->id,
            'user_id' => 1,
            'status' => 'pending',
        ]);
    }

    private function getIndeedMockResponse(): array
    {
        return [
            'jobs' => [
                [
                    'id' => 'indeed_job_123',
                    'title' => 'Senior PHP Developer',
                    'company' => [
                        'id' => 'company_123',
                        'name' => 'Test Company',
                    ],
                    'salary' => [
                        'min' => 80000,
                        'max' => 120000,
                    ],
                    'description' => 'Job description here',
                    'location' => 'Remote',
                ],
                [
                    'id' => 'indeed_job_456',
                    'title' => 'Full Stack Developer',
                    'company' => [
                        'id' => 'company_123',
                        'name' => 'Test Company',
                    ],
                    'salary' => [
                        'min' => 70000,
                        'max' => 100000,
                    ],
                    'description' => 'Another job description',
                    'location' => 'New York',
                ],
            ],
        ];
    }

    private function getLinkedInMockResponse(): array
    {
        return [
            'positions' => [
                [
                    'id' => 'linkedin_job_789',
                    'title' => 'Senior Backend Developer',
                    'company' => [
                        'id' => 'company_123',
                        'name' => 'Test Company',
                    ],
                    'compensation' => [
                        'minimum' => 90000,
                        'maximum' => 130000,
                    ],
                    'description' => 'LinkedIn job description',
                    'location' => 'San Francisco',
                ],
            ],
        ];
    }
}
