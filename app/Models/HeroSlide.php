<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'button_text',
        'button_link',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the image URL attribute
     */
    public function getImageUrlAttribute(): string
    {
        return Storage::url($this->image_path);
    }

    /**
     * Get the full download URL for the image
     */
    public function getImageDownloadUrlAttribute(): string
    {
        return url(Storage::url($this->image_path));
    }

    /**
     * Scope a query to only include active slides
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
