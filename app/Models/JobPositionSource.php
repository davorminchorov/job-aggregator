<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPositionSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_position_source_type_id',
        'name',
        'credentials',
        'last_synced_at',
        'is_active',
    ];

    protected $casts = [
        'credentials' => 'encrypted:array',
        'last_synced_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function sourceType(): BelongsTo
    {
        return $this->belongsTo(JobPositionSourceType::class, 'job_position_source_type_id');
    }
}
