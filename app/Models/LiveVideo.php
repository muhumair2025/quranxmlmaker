<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LiveVideo extends Model
{
    protected $fillable = [
        'title',
        'youtube_url',
        'scheduled_at',
        'status',
        'is_active',
        'order'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get YouTube video ID from URL
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        $url = $this->youtube_url;
        
        // Handle different YouTube URL formats
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
            return $matches[1];
        } elseif (preg_match('/youtube\.com\/live\/([^\&\?\/]+)/', $url, $matches)) {
            return $matches[1];
        } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
            return $matches[1];
        } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    /**
     * Get embed URL for YouTube video
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $videoId = $this->youtube_video_id;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        $videoId = $this->youtube_video_id;
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : null;
    }

    /**
     * Check if video is currently live
     */
    public function getIsLiveNowAttribute(): bool
    {
        return $this->status === 'live';
    }

    /**
     * Check if video is upcoming
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->status === 'upcoming' && $this->scheduled_at && $this->scheduled_at->isFuture();
    }

    /**
     * Scope a query to only include active videos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include live videos
     */
    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    /**
     * Scope a query to only include upcoming videos
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    /**
     * Scope a query to order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('scheduled_at', 'desc');
    }
}
