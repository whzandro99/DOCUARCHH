<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'document_type', 'document_number', 'sequence_number', 'year',
        'title', 'sender', 'recipient', 'document_date', 'office',
        'description', 'file_path', 'created_by'
    ];

    protected function casts(): array
    {
        return ['document_date' => 'date'];
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ArchiveLog::class)->latest();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return ['letter' => 'Letter', 'clearance' => 'Clearance Form', 'report' => 'Report'][$this->document_type] ?? $this->document_type;
    }
}
