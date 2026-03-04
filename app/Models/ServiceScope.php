<?php

namespace App\Models;

use App\Models\Concerns\HasSeoFallback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceScope extends Model
{
    use HasFactory, HasSeoFallback;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'custom_faq_json' => 'array',
            'noindex' => 'boolean',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeEntity(): Category|Brand|null
    {
        return match ($this->scope_type) {
            'category' => Category::find($this->scope_id),
            'brand' => Brand::find($this->scope_id),
            default => null,
        };
    }

    public function scopeForCategory($query, int $categoryId)
    {
        return $query->where('scope_type', 'category')->where('scope_id', $categoryId);
    }

    public function scopeForBrand($query, int $brandId)
    {
        return $query->where('scope_type', 'brand')->where('scope_id', $brandId);
    }

    public function getTemplateVariables(): array
    {
        $entity = $this->scopeEntity();

        $categoryName = '';
        $brandName = '';

        if ($this->scope_type === 'category' && $entity) {
            $categoryName = $entity->name;
        }

        if ($this->scope_type === 'brand' && $entity) {
            $brandName = $entity->name;
        }

        return [
            'category' => $categoryName,
            'brand' => $brandName,
            'model' => '',
            'service' => $this->service?->name ?? '',
            'city' => config('app.city', 'Москва'),
        ];
    }
}
