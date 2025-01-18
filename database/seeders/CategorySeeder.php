<?php

namespace Database\Seeders;

use App\Enums\CategoryName;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    protected array $descriptions = [
        CategoryName::BACKEND_DEVELOPMENT->value => 'Server-side development roles focusing on databases, application logic, and APIs.',
        CategoryName::FRONTEND_DEVELOPMENT->value => 'Client-side development roles focusing on user interfaces and browser-based applications.',
        CategoryName::FULL_STACK_DEVELOPMENT->value => 'End-to-end development roles covering both frontend and backend technologies.',
        CategoryName::DEVOPS->value => 'Roles focusing on deployment, infrastructure, and development operations.',
        CategoryName::MOBILE_DEVELOPMENT->value => 'Development roles for iOS, Android, and cross-platform mobile applications.',
        CategoryName::DATA_SCIENCE->value => 'Roles involving data analysis, machine learning, and statistical modeling.',
        CategoryName::UI_UX_DESIGN->value => 'Design roles focusing on user interfaces, user experience, and product design.',
        CategoryName::QA_TESTING->value => 'Quality assurance roles focusing on software testing and quality control.',
        CategoryName::PROJECT_MANAGEMENT->value => 'Roles managing software development projects and team coordination.',
        CategoryName::SECURITY->value => 'Cybersecurity roles focusing on application and infrastructure security.',
    ];

    public function run(): void
    {
        $categories = collect(CategoryName::cases())->map(function ($category) {
            return [
                'name' => $category->value,
                'slug' => Str::slug($category->name),
                'description' => $this->descriptions[$category->value],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        Category::insert($categories);
    }
}
