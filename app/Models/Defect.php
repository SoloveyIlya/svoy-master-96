<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Brand;
use App\Models\DeviceModel;

class Defect extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_bottom_text',
    ];

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
     * Плоский URL поломки: /{categorySlug}/{defectSlug}
     * (используется в resolveDefects() контроллера через $defect->resolved_url напрямую,
     *  но метод оставлен для обратной совместимости)
     */
    public function getUrl(?Brand $brand = null, ?DeviceModel $model = null): string
    {
        return url('/' . $this->category->slug . '/' . $this->slug);
    }

    /**
     * Ссылка на бренд из страницы поломки: теперь ведёт на /{category}/{brand} (плоский URL).
     */
    public function getBrandUrl(Brand $brand): string
    {
        return url('/' . $this->category->slug . '/' . $brand->slug);
    }
}
