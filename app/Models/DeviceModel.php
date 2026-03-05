<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceModel extends Model
{
    use HasFactory;

    protected $table = 'device_models';

    protected $guarded = [];

    protected $attributes = [
        'status' => 'active',
        'noindex' => false,
    ];

    protected function casts(): array
    {
        return [
            'seo_faq_json' => 'array',
            'noindex' => 'boolean',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function landingPages(): HasMany
    {
        return $this->hasMany(LandingPage::class, 'model_id');
    }
}
