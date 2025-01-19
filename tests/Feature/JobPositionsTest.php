<?php

namespace Tests\Feature;

use App\Enums\RoleName;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    #[Group('job-positions')]
    #[Group('view')]
    public function job_positions_index_page_displays_all_required_information(): void
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

    #[Test]
    #[Group('job-positions')]
    #[Group('search')]
    public function job_positions_can_be_searched_by_title_and_description(): void
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

    #[Test]
    #[Group('job-positions')]
    #[Group('filter')]
    public function job_positions_can_be_filtered_by_category(): void
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

    #[Test]
    #[Group('job-positions')]
    #[Group('filter')]
    public function job_positions_can_be_filtered_by_location_type(): void
    {
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $remotePosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'location' => 'Remote',
        ]);

        $hybridPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'location' => 'Hybrid',
        ]);

        $response = $this->get(route('positions.index', ['location' => 'remote']));
        $response->assertSee($remotePosition->title);
        $response->assertDontSee($hybridPosition->title);
    }

    #[Test]
    #[Group('job-positions')]
    #[Group('filter')]
    public function job_positions_can_be_filtered_by_salary_range(): void
    {
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $highSalaryPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'salary_min' => 100000,
            'salary_max' => 150000,
        ]);

        $lowSalaryPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'salary_min' => 40000,
            'salary_max' => 60000,
        ]);

        $response = $this->get(route('positions.index', ['salary_min' => 80000]));
        $response->assertSee($highSalaryPosition->title);
        $response->assertDontSee($lowSalaryPosition->title);
    }

    #[Test]
    #[Group('job-positions')]
    #[Group('sort')]
    public function job_positions_can_be_sorted_by_salary_date_and_title(): void
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

    #[Test]
    #[Group('job-positions')]
    #[Group('view')]
    public function job_position_details_page_shows_complete_information(): void
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

    #[Test]
    #[Group('job-positions')]
    #[Group('pagination')]
    public function job_positions_pagination_works_correctly(): void
    {
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        JobPosition::factory()->count(25)->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('positions.index'));
        $response->assertStatus(200);

        // Assuming 20 per page
        $this->assertCount(20, $response->json()['data']);
        $response->assertJsonPath('meta.total', 25);
    }

    #[Test]
    #[Group('job-positions')]
    #[Group('empty-state')]
    public function empty_state_is_shown_when_no_positions(): void
    {
        $response = $this->get(route('positions.index'));

        $response->assertStatus(200);
        $response->assertSee('No positions found');
    }
}
