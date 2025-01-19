<?php

namespace Tests\Feature\Integration;

use App\Enums\RoleName;
use App\Livewire\Forms\LoginForm;
use App\Livewire\JobPositionDetails;
use App\Livewire\JobPositions;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JobApplicationFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private JobPosition $position;
    private Company $company;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create([
            'name' => 'Test Company',
            'description' => 'A great place to work',
        ]);

        $this->category = Category::factory()->create([
            'name' => 'Development',
        ]);

        $this->position = JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Senior Developer',
            'salary_min' => 80000,
            'salary_max' => 120000,
        ]);

        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->user->assignRole(RoleName::MEMBER->value);
    }

    #[Test]
    #[Group('integration')]
    public function userCanBrowseAndApplyForJob(): void
    {
        // 1. User browses job positions
        Livewire::test(JobPositions::class)
            ->assertSee($this->position->title)
            ->assertSee($this->company->name)
            ->assertSee($this->category->name);

        // 2. User views job details
        $response = $this->get(route('positions.show', $this->position));
        $response->assertOk()
            ->assertSee($this->position->title)
            ->assertSee($this->company->name)
            ->assertSee($this->category->name)
            ->assertSee(number_format($this->position->salary_min))
            ->assertSee(number_format($this->position->salary_max));

        // 3. User logs in
        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertAuthenticatedAs($this->user);

        // 4. User applies for the position
        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertDispatched('position-applied', positionId: $this->position->id)
            ->assertHasFlash('success', 'Your application has been submitted successfully!');

        // 5. Verify application is recorded
        $this->assertDatabaseHas('job_applications', [
            'user_id' => $this->user->id,
            'job_position_id' => $this->position->id,
            'status' => 'pending',
        ]);
    }

    #[Test]
    #[Group('integration')]
    public function userCannotApplyTwiceForSamePosition(): void
    {
        // 1. User logs in
        Livewire::actingAs($this->user)
            ->test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        // 2. First application
        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertDispatched('position-applied')
            ->assertHasFlash('success');

        // 3. Second application attempt
        Livewire::test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertHasFlash('error', 'You have already applied for this position.');

        // 4. Verify only one application exists
        $this->assertDatabaseCount('job_applications', 1);
    }

    #[Test]
    #[Group('integration')]
    public function userCanSearchAndFilterBeforeApplying(): void
    {
        // Create additional test data
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Junior Developer',
            'salary_min' => 40000,
            'salary_max' => 60000,
        ]);

        // 1. User searches for senior positions
        Livewire::test(JobPositions::class)
            ->set('search', 'Senior')
            ->assertSee('Senior Developer')
            ->assertDontSee('Junior Developer');

        // 2. User filters by salary range
        Livewire::test(JobPositions::class)
            ->set('minSalary', 70000)
            ->assertSee('Senior Developer')
            ->assertDontSee('Junior Developer');

        // 3. User logs in and applies
        Livewire::actingAs($this->user)
            ->test(JobPositionDetails::class, ['position' => $this->position])
            ->call('apply')
            ->assertDispatched('position-applied')
            ->assertHasFlash('success');
    }

    #[Test]
    #[Group('integration')]
    public function companyCanTrackApplications(): void
    {
        // 1. Multiple users apply
        $users = User::factory(3)->create()->each(function ($user) {
            $user->assignRole(RoleName::MEMBER->value);
        });

        foreach ($users as $user) {
            Livewire::actingAs($user)
                ->test(JobPositionDetails::class, ['position' => $this->position])
                ->call('apply');
        }

        // 2. Verify applications in company dashboard
        $this->assertDatabaseCount('job_applications', 3);
        $this->assertEquals(3, $this->position->applications()->count());
        $this->assertEquals(3, $this->company->jobPositions()->first()->applications()->count());
    }
}
