<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class IconLibrary extends Model
{
    protected $table = 'icon_library';

    protected $fillable = [
        'name',
        'file_path',
        'file_type',
        'file_size',
        'original_name'
    ];

    protected $casts = [
        'file_size' => 'integer'
    ];

    /**
     * Get the categories using this icon.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'icon_library_id');
    }

    /**
     * Get the full icon URL.
     */
    public function getIconUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $units = ['B', 'KB', 'MB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Check if icon is in use by any category.
     */
    public function isInUse(): bool
    {
        return $this->categories()->exists();
    }
}
