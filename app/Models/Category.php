<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'name_english',
        'name_urdu',
        'name_arabic',
        'name_pashto',
        'description',
        'icon_library_id',
        'color',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'icon_library_id' => 'integer'
    ];

    /**
     * Get the icon from library.
     */
    public function iconLibrary(): BelongsTo
    {
        return $this->belongsTo(IconLibrary::class, 'icon_library_id');
    }

    /**
     * Get the subcategories for the category.
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class)->orderBy('order');
    }

    /**
     * Get active subcategories only.
     */
    public function activeSubcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class)->where('is_active', true)->orderBy('order');
    }

    /**
     * Get the icon URL.
     */
    public function getIconUrlAttribute(): ?string
    {
        return $this->iconLibrary?->icon_url;
    }

    /**
     * Get the display name (English by default).
     */
    public function getNameAttribute(): string
    {
        return $this->name_english ?? 'Unnamed Category';
    }

    /**
     * Get formatted display name with all languages.
     */
    public function getDisplayNameAttribute(): string
    {
        $names = [];
        if ($this->name_english) $names[] = $this->name_english;
        if ($this->name_urdu) $names[] = $this->name_urdu;
        if ($this->name_arabic) $names[] = $this->name_arabic;
        if ($this->name_pashto) $names[] = $this->name_pashto;
        
        return implode(' • ', $names);
    }

    /**
     * Get icon emoji/character.
     */
    public function getIconAttribute(): string
    {
        // Return empty string for now, or first character of icon if exists
        return '';
    }

    /**
     * Scope a query to only include active categories.
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
}

