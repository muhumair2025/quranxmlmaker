<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'category_id' => 'integer'
    ];

    /**
     * Get the category that owns the subcategory.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the contents for the subcategory.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    /**
     * Get active contents only.
     */
    public function activeContents(): HasMany
    {
        return $this->hasMany(Content::class)->where('is_active', true)->orderBy('order');
    }

    /**
     * Scope a query to only include active subcategories.
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
