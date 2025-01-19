<?php

namespace Tests\Feature\JobBoards;

use App\Services\JobBoards\IndeedJobBoard;
use App\Services\JobBoards\LinkedInJobBoard;
use App\Services\JobBoards\JobBoardFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class JobBoardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'api.indeed.com/*' => Http::response($this->getIndeedMockResponse(), 200),
            'api.linkedin.com/*' => Http::response($this->getLinkedInMockResponse(), 200),
        ]);
    }

    #[Test]
    #[Group('job-boards')]
    public function factoryCreatesCorrectJobBoard(): void
    {
        $factory = new JobBoardFactory();

        $indeedBoard = $factory->create('indeed');
        $linkedInBoard = $factory->create('linkedin');

        $this->assertInstanceOf(IndeedJobBoard::class, $indeedBoard);
        $this->assertInstanceOf(LinkedInJobBoard::class, $linkedInBoard);
    }

    #[Test]
    #[Group('job-boards')]
    public function factoryThrowsExceptionForInvalidSource(): void
    {
        $factory = new JobBoardFactory();

        $this->expectException(\InvalidArgumentException::class);
        $factory->create('invalid-source');
    }

    #[Test]
    #[Group('job-boards')]
    public function indeedBoardParsesResponseCorrectly(): void
    {
        $board = new IndeedJobBoard();
        $positions = $board->fetch();

        $this->assertCount(2, $positions);

        $position = $positions[0];
        $this->assertEquals('indeed_job_123', $position['external_id']);
        $this->assertEquals('Senior PHP Developer', $position['title']);
        $this->assertEquals(80000, $position['salary_min']);
        $this->assertEquals(120000, $position['salary_max']);
        $this->assertEquals('Remote', $position['location']);
    }

    #[Test]
    #[Group('job-boards')]
    public function linkedInBoardParsesResponseCorrectly(): void
    {
        $board = new LinkedInJobBoard();
        $positions = $board->fetch();

        $this->assertCount(1, $positions);

        $position = $positions[0];
        $this->assertEquals('linkedin_job_789', $position['external_id']);
        $this->assertEquals('Senior Backend Developer', $position['title']);
        $this->assertEquals(90000, $position['salary_min']);
        $this->assertEquals(130000, $position['salary_max']);
        $this->assertEquals('San Francisco', $position['location']);
    }

    #[Test]
    #[Group('job-boards')]
    public function indeedBoardHandlesEmptyResponse(): void
    {
        Http::fake([
            'api.indeed.com/*' => Http::response(['jobs' => []], 200),
        ]);

        $board = new IndeedJobBoard();
        $positions = $board->fetch();

        $this->assertEmpty($positions);
    }

    #[Test]
    #[Group('job-boards')]
    public function linkedInBoardHandlesEmptyResponse(): void
    {
        Http::fake([
            'api.linkedin.com/*' => Http::response(['positions' => []], 200),
        ]);

        $board = new LinkedInJobBoard();
        $positions = $board->fetch();

        $this->assertEmpty($positions);
    }

    #[Test]
    #[Group('job-boards')]
    public function indeedBoardHandlesPartialData(): void
    {
        Http::fake([
            'api.indeed.com/*' => Http::response([
                'jobs' => [[
                    'id' => 'indeed_job_123',
                    'title' => 'Developer',
                    // Missing salary and location
                ]],
            ], 200),
        ]);

        $board = new IndeedJobBoard();
        $positions = $board->fetch();

        $this->assertCount(1, $positions);
        $this->assertEquals('Developer', $positions[0]['title']);
        $this->assertNull($positions[0]['salary_min']);
        $this->assertNull($positions[0]['salary_max']);
        $this->assertNull($positions[0]['location']);
    }

    #[Test]
    #[Group('job-boards')]
    public function linkedInBoardHandlesPartialData(): void
    {
        Http::fake([
            'api.linkedin.com/*' => Http::response([
                'positions' => [[
                    'id' => 'linkedin_job_789',
                    'title' => 'Developer',
                    // Missing compensation and location
                ]],
            ], 200),
        ]);

        $board = new LinkedInJobBoard();
        $positions = $board->fetch();

        $this->assertCount(1, $positions);
        $this->assertEquals('Developer', $positions[0]['title']);
        $this->assertNull($positions[0]['salary_min']);
        $this->assertNull($positions[0]['salary_max']);
        $this->assertNull($positions[0]['location']);
    }

    #[Test]
    #[Group('job-boards')]
    public function boardsHandleApiErrors(): void
    {
        Http::fake([
            'api.indeed.com/*' => Http::response(['error' => 'Service unavailable'], 503),
            'api.linkedin.com/*' => Http::response(['error' => 'Service unavailable'], 503),
        ]);

        $indeedBoard = new IndeedJobBoard();
        $linkedInBoard = new LinkedInJobBoard();

        $this->expectException(\RuntimeException::class);
        $indeedBoard->fetch();

        $this->expectException(\RuntimeException::class);
        $linkedInBoard->fetch();
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
