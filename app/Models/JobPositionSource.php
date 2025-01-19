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
        'credentials' => 'array',
        'last_synced_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected function setCredentialsAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        $this->attributes['credentials'] = is_array($value) ? json_encode($value) : null;
    }

    public function sourceType(): BelongsTo
    {
        return $this->belongsTo(JobPositionSourceType::class, 'job_position_source_type_id');
    }
}
