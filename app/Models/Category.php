<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'seo_faq_json' => 'array',
            'noindex' => 'boolean',
        ];
    }

    public function deviceModels(): HasMany
    {
        return $this->hasMany(DeviceModel::class);
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
}
