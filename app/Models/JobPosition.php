<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPosition extends Model
{
    use HasFactory;

    protected $table = 'job_positions';

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'benefits',
        'salary_min',
        'salary_max',
        'location',
        'type',
        'company_id',
        'category_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
