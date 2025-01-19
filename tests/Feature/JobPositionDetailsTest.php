<?php

namespace Tests\Feature;

use App\Livewire\JobPositionDetails;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JobPositionDetailsTest extends TestCase
{
    use RefreshDatabase;

    private JobPosition $position;

    protected function setUp(): void
    {
        parent::setUp();

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $this->position = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
        ]);
    }

    #[Test]
    #[Group('job-positions')]
    public function showsJobPositionDetails(): void
    {
        $this->get(route('positions.show', $this->position))
            ->assertOk()
            ->assertSeeLivewire(JobPositionDetails::class);
    }

    #[Test]
    #[Group('job-positions')]
    public function loadsRelatedCompanyAndCategory(): void
    {
        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->assertSet('position.company.id', $this->position->company->id)
            ->assertSet('position.category.id', $this->position->category->id);
    }

    #[Test]
    #[Group('job-positions')]
    public function unauthenticatedUserIsRedirectedToLoginWhenApplying(): void
    {
        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertRedirect(route('login'));
    }

    #[Test]
    #[Group('job-positions')]
    public function authenticatedUserCanApplyForPosition(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertDispatched('position-applied', positionId: $this->position->id)
            ->assertHasFlash('success', 'Your application has been submitted successfully!');

        $this->assertDatabaseHas('job_applications', [
            'user_id' => $user->id,
            'job_position_id' => $this->position->id,
            'status' => 'pending',
        ]);
    }

    #[Test]
    #[Group('job-positions')]
    public function handlesDeletedCompany(): void
    {
        $this->position->company->delete();

        Livewire::test(JobPositionDetails::class, ['position' => $this->position->fresh()])
            ->assertSee('Company information unavailable');
    }

    #[Test]
    #[Group('job-positions')]
    public function handlesDeletedCategory(): void
    {
        $this->position->category->delete();

        Livewire::test(JobPositionDetails::class, ['position' => $this->position->fresh()])
            ->assertSee('Category information unavailable');
    }

    #[Test]
    #[Group('job-positions')]
    public function showsApplicationDeadline(): void
    {
        $this->position->update([
            'application_deadline' => now()->addDays(5),
        ]);

        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->assertSee('5 days remaining');
    }

    #[Test]
    #[Group('job-positions')]
    public function preventsApplicationAfterDeadline(): void
    {
        $user = User::factory()->create();
        $this->position->update([
            'application_deadline' => now()->subDay(),
        ]);

        Livewire::actingAs($user)
            ->test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertHasFlash('error', 'The application deadline has passed.');

        $this->assertDatabaseMissing('job_applications', [
            'user_id' => $user->id,
            'job_position_id' => $this->position->id,
        ]);
    }

    #[Test]
    #[Group('job-positions')]
    public function showsRequiredSkills(): void
    {
        $this->position->update([
            'required_skills' => ['PHP', 'Laravel', 'MySQL'],
        ]);

        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->assertSee('PHP')
            ->assertSee('Laravel')
            ->assertSee('MySQL');
    }

    #[Test]
    #[Group('job-positions')]
    public function showsExperienceLevel(): void
    {
        $this->position->update([
            'experience_level' => 'senior',
            'years_of_experience' => 5,
        ]);

        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->assertSee('Senior Level')
            ->assertSee('5+ years of experience');
    }

    #[Test]
    #[Group('job-positions')]
    public function handlesPositionBeingFilled(): void
    {
        $user = User::factory()->create();
        $this->position->update(['is_filled' => true]);

        Livewire::actingAs($user)
            ->test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertHasFlash('error', 'This position has been filled.');

        $this->assertDatabaseMissing('job_applications', [
            'user_id' => $user->id,
            'job_position_id' => $this->position->id,
        ]);
    }

    #[Test]
    #[Group('job-positions')]
    public function showsApplicationCount(): void
    {
        User::factory(3)->create()->each(function ($user) {
            $this->position->applications()->create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        });

        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->assertSee('3 applications received');
    }
}
