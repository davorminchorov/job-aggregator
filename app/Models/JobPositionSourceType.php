<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPositionSourceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'description',
        'required_fields',
        'is_active',
    ];

    protected $casts = [
        'required_fields' => 'array',
        'is_active' => 'boolean',
    ];

    public function sources(): HasMany
    {
        return $this->hasMany(JobPositionSource::class);
    }
}
