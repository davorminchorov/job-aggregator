<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirtableSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_id',
        'table_id',
        'api_key',
        'last_synced_at',
        'is_active',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
