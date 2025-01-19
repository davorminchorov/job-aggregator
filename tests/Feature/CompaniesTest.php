<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the member role
        Role::create(['name' => 'member']);
    }

    public function test_user_can_view_companies_page(): void
    {
        // Create test data
        $company = Company::factory()->create();

        // Visit the page
        $response = $this->get(route('companies.index'));

        // Assert the response
        $response->assertStatus(200);
        $response->assertSee($company->name);
        $response->assertSee($company->location);
        $response->assertSee($company->industry);
    }

    public function test_user_can_search_companies(): void
    {
        // Create companies with different names
        $matchingCompany = Company::factory()->create([
            'name' => 'Acme Corporation',
            'description' => 'A tech company',
        ]);

        $nonMatchingCompany = Company::factory()->create([
            'name' => 'Other Corp',
            'description' => 'Another company',
        ]);

        // Test name search
        $response = $this->get(route('companies.index', ['search' => 'Acme']));
        $response->assertStatus(200);
        $response->assertSee($matchingCompany->name);
        $response->assertDontSee($nonMatchingCompany->name);

        // Test description search
        $response = $this->get(route('companies.index', ['search' => 'tech']));
        $response->assertStatus(200);
        $response->assertSee($matchingCompany->name);
        $response->assertDontSee($nonMatchingCompany->name);
    }

    public function test_user_can_sort_companies(): void
    {
        // Create companies with different attributes
        $olderCompany = Company::factory()->create([
            'name' => 'Acme Corp',
            'created_at' => now()->subDays(2),
        ]);

        $newerCompany = Company::factory()->create([
            'name' => 'Beta Corp',
            'created_at' => now()->subDay(),
        ]);

        // Create job positions to test positions count sorting
        JobPosition::factory(3)->create(['company_id' => $olderCompany->id]);
        JobPosition::factory(1)->create(['company_id' => $newerCompany->id]);

        // Test sorting by name
        $response = $this->get(route('companies.index', ['sortBy' => 'name']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Acme Corp',
            'Beta Corp',
        ]);

        // Test sorting by latest
        $response = $this->get(route('companies.index', ['sortBy' => 'latest']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Beta Corp',
            'Acme Corp',
        ]);

        // Test sorting by positions count
        $response = $this->get(route('companies.index', ['sortBy' => 'positions_count']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Acme Corp',
            'Beta Corp',
        ]);
    }

    public function test_user_can_view_company_details(): void
    {
        // Create test data
        $company = Company::factory()->create([
            'name' => 'Test Company',
            'description' => 'A test company description',
            'location' => 'Test Location',
            'industry' => 'Technology',
            'size' => '51-200',
            'founded_year' => 2020,
            'website' => 'https://example.com',
        ]);

        $position = JobPosition::factory()->create([
            'company_id' => $company->id,
            'title' => 'Senior Developer',
            'location' => 'Remote',
            'type' => 'Full-time',
            'salary_min' => 80000,
            'salary_max' => 120000,
        ]);

        // Visit the details page
        $response = $this->get(route('companies.show', $company));

        // Assert the response
        $response->assertStatus(200);
        $response->assertSee($company->name);
        $response->assertSee($company->description);
        $response->assertSee($company->location);
        $response->assertSee($company->industry);
        $response->assertSee($company->size);
        $response->assertSee($company->founded_year);
        $response->assertSee($company->website);
        $response->assertSee($position->title);
        $response->assertSee($position->location);
        $response->assertSee($position->type);
        $response->assertSee('80,000');
        $response->assertSee('120,000');
    }

    public function test_user_can_search_company_positions(): void
    {
        // Create test data
        $company = Company::factory()->create();

        $matchingPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'title' => 'Senior Laravel Developer',
            'description' => 'PHP development position',
        ]);

        $nonMatchingPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'title' => 'React Developer',
            'description' => 'Frontend position',
        ]);

        // Test the search functionality
        $response = $this->get(route('companies.show', [
            'company' => $company,
            'search' => 'Laravel',
        ]));

        // Assert the response
        $response->assertStatus(200);
        $response->assertSee($matchingPosition->title);
        $response->assertDontSee($nonMatchingPosition->title);
    }

    public function test_user_can_sort_company_positions(): void
    {
        // Create test data
        $company = Company::factory()->create();

        $lowSalaryPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'title' => 'Junior Developer',
            'salary_min' => 40000,
            'salary_max' => 60000,
        ]);

        $highSalaryPosition = JobPosition::factory()->create([
            'company_id' => $company->id,
            'title' => 'Senior Developer',
            'salary_min' => 100000,
            'salary_max' => 150000,
        ]);

        // Test sorting by title
        $response = $this->get(route('companies.show', [
            'company' => $company,
            'sortBy' => 'title',
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Junior Developer',
            'Senior Developer',
        ]);

        // Test sorting by highest salary
        $response = $this->get(route('companies.show', [
            'company' => $company,
            'sortBy' => 'salary_high',
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Senior Developer',
            'Junior Developer',
        ]);

        // Test sorting by lowest salary
        $response = $this->get(route('companies.show', [
            'company' => $company,
            'sortBy' => 'salary_low',
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Junior Developer',
            'Senior Developer',
        ]);
    }
}
