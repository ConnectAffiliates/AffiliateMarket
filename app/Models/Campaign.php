<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'budget',
        'spent',
        'user_id',
        'image',
        'start_date',
        'end_date',
        'commission_type',
        'commission_value',
        'terms',
        'tracking_url',
        'target_audience',
        'allowed_promotion_methods',
        'impressions',
        'clicks',
        'conversions'
    ];

    protected $casts = [
        'budget' => 'float',
        'spent' => 'float',
        'impressions' => 'integer',
        'clicks' => 'integer',
        'conversions' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'allowed_promotion_methods' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    // Format budget with currency symbol
    public function getFormattedBudgetAttribute()
    {
        return 'TZS ' . number_format($this->budget, 0);
    }

    // Format spent with currency symbol
    public function getFormattedSpentAttribute()
    {
        return 'TZS ' . number_format($this->spent, 0);
    }

    // Calculate CTR (Click-Through Rate)
    public function getCtrAttribute()
    {
        if ($this->impressions == 0) {
            return '0%';
        }
        
        $ctr = ($this->clicks / $this->impressions) * 100;
        return number_format($ctr, 2) . '%';
    }

    // Calculate Conversion Rate
    public function getConversionRateAttribute()
    {
        if ($this->clicks == 0) {
            return '0%';
        }
        
        $convRate = ($this->conversions / $this->clicks) * 100;
        return number_format($convRate, 2) . '%';
    }
}
