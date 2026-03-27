<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportRun extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'status' => 'running',
    ];

    protected $fillable = [
        'started_at',
        'finished_at',
        'status',
        'stats_json',
        'initiated_by',
        'seed_url',
    ];

    protected function casts(): array
    {
        return [
            'stats_json'  => 'array',
            'started_at'  => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    public function urls(): HasMany
    {
        return $this->hasMany(ImportUrl::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ImportItem::class);
    }

    public function incrementStat(string $key, int $amount = 1): void
    {
        $stats = $this->stats_json ?? [];
        $stats[$key] = ($stats[$key] ?? 0) + $amount;
        $this->update(['stats_json' => $stats]);
    }
}
