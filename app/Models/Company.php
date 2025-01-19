<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'website',
        'logo',
        'location',
        'industry',
        'size',
        'founded_year',
        'email',
        'phone',
    ];

    public function jobPositions(): HasMany
    {
        return $this->hasMany(JobPosition::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasManyThrough(JobApplication::class, JobPosition::class);
    }
}
