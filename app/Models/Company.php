<?php

namespace App\Models;

use App\Enums\CompanySize;
use App\Enums\IndustryName;
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

    protected $casts = [
        'industry' => IndustryName::class,
        'size' => CompanySize::class,
        'founded_year' => 'integer',
    ];

    public function jobPositions(): HasMany
    {
        return $this->hasMany(JobPosition::class);
    }
}
