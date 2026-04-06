<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\LandingPage;
use App\Models\ServiceScope;

class Defect extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Формирует URL для поломки в зависимости от контекста (категория, бренд, модель).
     * Если специфическая страница (landing или service-scope) не существует, 
     * возвращает ссылку на общую страницу поломки (catalog.defect).
     */
    public function getUrl(?Brand $brand = null, ?DeviceModel $model = null): string
    {
        return route('catalog.defect', [$this->category->slug, $this->slug]);
    }

    /**
     * Формирует ссылку для перехода из общей поломки конкретно на бренд.
     * Если у поломки есть привязанная услуга и существует ServiceScope для бренда - ведем туда.
     * Иначе ведем на основную страницу бренда.
     */
    public function getBrandUrl(Brand $brand): string
    {
        if ($this->service_id && $this->service) {
            $exists = ServiceScope::forBrand($brand->id)
                ->where('service_id', $this->service_id)
                ->where('status', 'active')
                ->exists();
                
            if ($exists) {
                return route('catalog.service-scope-brand', [
                    'categorySlug' => $this->category->slug,
                    'brandSlug' => $brand->slug,
                    'serviceSlug' => $this->service->slug
                ]);
            }
        }

        return route('catalog.brand', [$this->category->slug, $brand->slug]);
    }
}
