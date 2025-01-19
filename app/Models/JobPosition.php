<?php

namespace App\Models;

use App\Enums\JobType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobPosition extends Model
{
    use HasFactory;

    protected $table = 'job_positions';

    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'slug',
        'description',
        'requirements',
        'benefits',
        'salary_range',
        'location',
        'type',
    ];

    protected $casts = [
        'type' => JobType::class,
        'benefits' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')
            ->withTimestamps();
    }

    public function isBookmarkedByUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->bookmarkedByUsers()->where('user_id', $user->id)->exists();
    }
}
