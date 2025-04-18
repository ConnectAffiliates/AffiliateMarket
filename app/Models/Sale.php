<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Sale extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'campaign_id',
        'referral_id',
        'affiliate_id',
        'advertiser_id',
        'customer_name',
        'customer_email',
        'amount',
        'commission',
        'status',
        'order_id',
        'ip_address',
        'notes'
    ];

    protected $casts = [
        'amount' => 'float',
        'commission' => 'float',
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

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    // Format amount with currency symbol
    public function getFormattedAmountAttribute()
    {
        return 'TZS ' . number_format($this->amount, 0);
    }

    // Format commission with currency symbol
    public function getFormattedCommissionAttribute()
    {
        return 'TZS ' . number_format($this->commission, 0);
    }
} 