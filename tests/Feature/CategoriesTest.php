<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the member role
        Role::create(['name' => 'member']);
    }

    public function test_user_can_view_categories_page(): void
    {
        // Create test data
        $category = Category::factory()->create();
        $company = Company::factory()->create();
        JobPosition::factory()->count(3)->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
        ]);

        // Visit the page
        $response = $this->get(route('categories.index'));

        // Assert the response
        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee('3 positions'); // Should show the count of positions
    }

    public function test_user_can_search_categories(): void
    {
        // Create categories with unique slugs
        $matchingCategory = Category::factory()->create([
            'name' => 'Frontend Development',
            'slug' => 'frontend-development',
            'description' => 'Frontend development positions',
        ]);

        $nonMatchingCategory = Category::factory()->create([
            'name' => 'Backend Development',
            'slug' => 'backend-development',
            'description' => 'Backend development positions',
        ]);

        // Test name search
        $response = $this->get(route('categories.index', ['search' => 'Frontend']));
        $response->assertStatus(200);
        $response->assertSee('Frontend Development');
        $response->assertDontSee('Backend Development');

        // Test description search
        $response = $this->get(route('categories.index', ['search' => 'Frontend development positions']));
        $response->assertStatus(200);
        $response->assertSee('Frontend Development');
        $response->assertDontSee('Backend Development');
    }

    public function test_user_can_sort_categories(): void
    {
        // Create test data
        $company = Company::factory()->create();

        $categoryA = Category::factory()->create(['name' => 'Backend Development']);
        JobPosition::factory()->count(5)->create([
            'company_id' => $company->id,
            'category_id' => $categoryA->id,
        ]);

        $categoryB = Category::factory()->create(['name' => 'Frontend Development']);
        JobPosition::factory()->count(2)->create([
            'company_id' => $company->id,
            'category_id' => $categoryB->id,
        ]);

        // Test sorting by most positions
        $response = $this->get(route('categories.index', ['sortBy' => 'positions_count']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $categoryA->name,
            $categoryB->name,
        ]);

        // Test sorting by name
        $response = $this->get(route('categories.index', ['sortBy' => 'name']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $categoryA->name,
            $categoryB->name,
        ]);

        // Test sorting by latest
        $response = $this->get(route('categories.index', ['sortBy' => 'latest']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $categoryB->name,
            $categoryA->name,
        ]);
    }

    public function test_empty_state_is_shown_when_no_categories(): void
    {
        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('No categories found');
    }
}
