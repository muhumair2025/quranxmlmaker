<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AppSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description'
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Handle different types
        switch ($setting->type) {
            case 'boolean':
                return filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
            case 'json':
                return json_decode($setting->value, true);
            case 'image':
                return $setting->value ? Storage::url($setting->value) : null;
            default:
                return $setting->value;
        }
    }

    /**
     * Set a setting value by key
     */
    public static function set(string $key, $value, string $type = 'text'): void
    {
        $setting = self::firstOrNew(['key' => $key]);
        
        if ($type === 'json') {
            $setting->value = json_encode($value);
        } else {
            $setting->value = $value;
        }
        
        $setting->type = $type;
        $setting->save();
    }

    /**
     * Get image download URL
     */
    public function getImageDownloadUrlAttribute(): ?string
    {
        if ($this->type === 'image' && $this->value) {
            return url(Storage::url($this->value));
        }
        return null;
    }
}
