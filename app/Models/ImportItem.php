<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportItem extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'payload_json' => 'array',
            'parsed_at' => 'datetime',
        ];
    }

    public function importRun(): BelongsTo
    {
        return $this->belongsTo(ImportRun::class);
    }

    public function sourceUrl(): BelongsTo
    {
        return $this->belongsTo(ImportUrl::class, 'source_url_id');
    }
}
