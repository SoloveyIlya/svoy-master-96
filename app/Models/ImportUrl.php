<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportUrl extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'status' => 'new',
    ];

    protected function casts(): array
    {
        return [
            'last_fetched_at' => 'datetime',
        ];
    }

    public function importRun(): BelongsTo
    {
        return $this->belongsTo(ImportRun::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ImportItem::class, 'source_url_id');
    }

    public function markFailed(string $error): void
    {
        $this->update([
            'status' => 'failed',
            'error_text' => $error,
        ]);
    }
}
