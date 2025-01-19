<?php

namespace Tests\Feature;

use App\Livewire\CompanyDetails;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CompanyDetailsTest extends TestCase
{
    use RefreshDatabase;

    private Company $company;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create();
        $this->category = Category::factory()->create();
    }

    #[Test]
    #[Group('companies')]
    public function showsCompanyDetails(): void
    {
        $this->get(route('companies.show', $this->company))
            ->assertOk()
            ->assertSeeLivewire(CompanyDetails::class);
    }

    #[Test]
    #[Group('companies')]
    public function searchFilterWorks(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Senior PHP Developer',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Junior JavaScript Developer',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('search', 'PHP')
            ->assertSee('Senior PHP Developer')
            ->assertDontSee('Junior JavaScript Developer');
    }

    #[Test]
    #[Group('companies')]
    public function sortingByTitleWorks(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Senior Developer',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Junior Developer',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('sortBy', 'title')
            ->assertSeeInOrder(['Junior Developer', 'Senior Developer']);
    }

    #[Test]
    #[Group('companies')]
    public function sortingBySalaryHighWorks(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_max' => 100000,
            'title' => 'Low Salary Position',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_max' => 150000,
            'title' => 'High Salary Position',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('sortBy', 'salary_high')
            ->assertSeeInOrder(['High Salary Position', 'Low Salary Position']);
    }

    #[Test]
    #[Group('companies')]
    public function sortingBySalaryLowWorks(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_min' => 50000,
            'title' => 'High Min Salary',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_min' => 30000,
            'title' => 'Low Min Salary',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('sortBy', 'salary_low')
            ->assertSeeInOrder(['Low Min Salary', 'High Min Salary']);
    }

    #[Test]
    #[Group('companies')]
    public function paginationWorks(): void
    {
        JobPosition::factory(15)->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->assertViewHas('positions', function ($positions) {
                return $positions->count() === 10; // First page should have 10 items
            });
    }

    #[Test]
    #[Group('companies')]
    public function searchResetsPageNumber(): void
    {
        JobPosition::factory(15)->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('page', 2)
            ->set('search', 'something')
            ->assertSet('page', 1);
    }

    #[Test]
    #[Group('companies')]
    public function searchFilterHandlesSpecialCharacters(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'C++ Developer',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Regular Developer',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('search', 'C++')
            ->assertSee('C++ Developer')
            ->assertDontSee('Regular Developer');
    }

    #[Test]
    #[Group('companies')]
    public function searchFilterHandlesEmptyResults(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'title' => 'Developer',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('search', 'NonexistentPosition')
            ->assertSee('No positions found')
            ->assertDontSee('Developer');
    }

    #[Test]
    #[Group('companies')]
    public function sortingHandlesEqualValues(): void
    {
        $firstPosition = JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_min' => 50000,
            'title' => 'First Position',
            'created_at' => now()->subDay(),
        ]);

        $secondPosition = JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_min' => 50000,
            'title' => 'Second Position',
            'created_at' => now(),
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('sortBy', 'salary_low')
            ->assertSeeInOrder(['First Position', 'Second Position']);
    }

    #[Test]
    #[Group('companies')]
    public function paginationHandlesLastPage(): void
    {
        JobPosition::factory(15)->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('page', 2)
            ->assertViewHas('positions', function ($positions) {
                return $positions->count() === 5; // Last page should have 5 items
            });
    }

    #[Test]
    #[Group('companies')]
    public function searchFilterWorksWithLocation(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'location' => 'New York',
            'title' => 'Position 1',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'location' => 'San Francisco',
            'title' => 'Position 2',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('search', 'York')
            ->assertSee('Position 1')
            ->assertDontSee('Position 2');
    }

    #[Test]
    #[Group('companies')]
    public function searchFilterWorksWithDescription(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'description' => 'Experience with Docker required',
            'title' => 'Position 1',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'description' => 'No special requirements',
            'title' => 'Position 2',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('search', 'Docker')
            ->assertSee('Position 1')
            ->assertDontSee('Position 2');
    }

    #[Test]
    #[Group('companies')]
    public function sortingHandlesNullSalaries(): void
    {
        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_min' => null,
            'salary_max' => null,
            'title' => 'No Salary Listed',
        ]);

        JobPosition::factory()->create([
            'company_id' => $this->company->id,
            'category_id' => $this->category->id,
            'salary_min' => 50000,
            'salary_max' => 100000,
            'title' => 'With Salary',
        ]);

        Livewire::test(CompanyDetails::class, ['company' => $this->company])
            ->set('sortBy', 'salary_high')
            ->assertSeeInOrder(['With Salary', 'No Salary Listed']);
    }
}
