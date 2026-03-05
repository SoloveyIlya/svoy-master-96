<?php

namespace App\Models;

use App\Models\Concerns\HasSeoFallback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingPage extends Model
{
    use HasFactory, HasSeoFallback;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'active',
        'noindex' => false,
    ];

    protected function casts(): array
    {
        return [
            'custom_faq_json' => 'array',
            'noindex' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function deviceModel(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, 'model_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function getTemplateVariables(): array
    {
        return [
            'category' => $this->category?->name ?? '',
            'brand' => $this->brand?->name ?? '',
            'model' => $this->deviceModel?->name ?? '',
            'service' => $this->service?->name ?? '',
            'city' => config('app.city', 'Москва'),
        ];
    }
}
