<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    protected $fillable = [
        'subcategory_id',
        'type',
        'title',
        'text_content',
        'question',
        'answer',
        'pdf_url',
        'audio_url',
        'video_url',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'subcategory_id' => 'integer'
    ];

    /**
     * Get the subcategory that owns the content.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }


    /**
     * Scope a query to only include active contents.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope a query to filter by content type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
