<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'advertiser_id',
        'budget',
        'cost_per_click',
        'cost_per_action',
        'target_url',
        'status',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'cost_per_click' => 'decimal:2',
        'cost_per_action' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
