<?php

namespace Tests\Feature;

use App\Enums\RoleName;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class JobPositionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the member role
        Role::create(['name' => RoleName::MEMBER->value]);
    }

    public function test_user_can_view_job_positions_page(): void
    {
        // Create test data
        $company = Company::factory()->create();
        $category = Category::factory()->create();
        $position = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
        ]);

        // Visit the page
        $response = $this->get(route('positions.index'));

        // Assert the response
        $response->assertStatus(200);
        $response->assertSee($position->title);
        $response->assertSee($company->name);
        $response->assertSee($category->name);
    }

    public function test_user_can_search_job_positions(): void
    {
        // Create test data
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        // Create positions with different titles
        $matchingPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'title' => 'Senior Laravel Developer',
            'description' => 'PHP development position',
        ]);

        $nonMatchingPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'title' => 'React Developer',
            'description' => 'Frontend position',
        ]);

        // Test title search
        $response = $this->get(route('positions.index', ['search' => 'Laravel']));
        $response->assertStatus(200);
        $response->assertSee($matchingPosition->title);
        $response->assertDontSee($nonMatchingPosition->title);

        // Test description search
        $response = $this->get(route('positions.index', ['search' => 'PHP development']));
        $response->assertStatus(200);
        $response->assertSee($matchingPosition->title);
        $response->assertDontSee($nonMatchingPosition->title);
    }

    public function test_user_can_filter_job_positions_by_category(): void
    {
        // Create test data
        $company = Company::factory()->create();
        $category1 = Category::factory()->create(['name' => 'Backend Development']);
        $category2 = Category::factory()->create(['name' => 'Frontend Development']);

        $backendPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category1->id,
        ]);

        $frontendPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category2->id,
        ]);

        // Test the category filter
        $response = $this->get(route('positions.index', ['category' => $category1->slug]));

        // Assert the response
        $response->assertStatus(200);
        $response->assertSee($backendPosition->title);
        $response->assertDontSee($frontendPosition->title);
    }

    public function test_user_can_sort_job_positions(): void
    {
        // Create a category and company for the job positions
        $category = Category::factory()->create();
        $company = Company::factory()->create();

        // Create job positions with distinct salaries
        $lowSalaryPosition = JobPosition::factory()->create([
            'title' => 'Junior Developer',
            'salary_min' => 40000,
            'salary_max' => 60000,
            'category_id' => $category->id,
            'company_id' => $company->id,
            'created_at' => now()->subDay(),
        ]);

        $highSalaryPosition = JobPosition::factory()->create([
            'title' => 'Senior Developer',
            'salary_min' => 100000,
            'salary_max' => 150000,
            'category_id' => $category->id,
            'company_id' => $company->id,
            'created_at' => now(),
        ]);

        // Test sorting by lowest salary
        $response = $this->get(route('positions.index', ['sortBy' => 'salary_low']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Junior Developer',
            'Senior Developer',
        ]);

        // Test sorting by highest salary
        $response = $this->get(route('positions.index', ['sortBy' => 'salary_high']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Senior Developer',
            'Junior Developer',
        ]);

        // Test sorting by latest
        $response = $this->get(route('positions.index', ['sortBy' => 'latest']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Senior Developer',
            'Junior Developer',
        ]);

        // Test sorting by title
        $response = $this->get(route('positions.index', ['sortBy' => 'title']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Junior Developer',
            'Senior Developer',
        ]);
    }

    public function test_user_can_view_job_position_details(): void
    {
        // Create test data
        $company = Company::factory()->create();
        $category = Category::factory()->create();
        $position = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'title' => 'Senior Developer Position',
            'description' => 'This is a test job description',
            'requirements' => "- 3+ years of relevant experience\n- Experience with GraphQL\n- Experience with Azure\n- Experience with Python",
            'benefits' => "- Competitive salary\n- Remote work\n- Health insurance",
            'location' => 'Remote',
            'type' => 'Full-time',
            'salary_min' => 80000,
            'salary_max' => 120000,
        ]);

        // Visit the details page
        $response = $this->get(route('positions.show', $position));

        // Assert the response
        $response->assertStatus(200);
        $response->assertSee($position->title);
        $response->assertSee($company->name);
        $response->assertSee($category->name);
        $response->assertSee('3+ years of relevant experience');
        $response->assertSee('Experience with GraphQL');
        $response->assertSee('Experience with Azure');
        $response->assertSee('Experience with Python');
        $response->assertSee('Competitive salary');
        $response->assertSee('Remote work');
        $response->assertSee('Health insurance');
        $response->assertSee('$80,000 - $120,000 per year');
    }

    public function test_empty_state_is_shown_when_no_positions(): void
    {
        $response = $this->get(route('positions.index'));

        $response->assertStatus(200);
        $response->assertSee('No positions found');
    }
}
