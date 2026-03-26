<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'active',
    ];

    protected function casts(): array
    {
        return [
            'default_faq_json' => 'array',
        ];
    }

    public function landingPages(): HasMany
    {
        return $this->hasMany(LandingPage::class);
    }

    public function serviceScopes(): HasMany
    {
        return $this->hasMany(ServiceScope::class);
    }

    public function defects(): HasMany
    {
        return $this->hasMany(Defect::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_service');
    }
}
