<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

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

    public function models(): HasMany
    {
        return $this->hasMany(DeviceModel::class);
    }

    public function brands()
    {
        // Пока пусто
    }

    public function landingPages(): HasMany
    {
        return $this->hasMany(LandingPage::class);
    }

    public function serviceScopes(): HasMany
    {
        return $this->hasMany(ServiceScope::class, 'scope_id')
            ->where('scope_type', 'category');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'category_service');
    }
}
