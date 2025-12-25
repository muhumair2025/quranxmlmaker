<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\AppSetting;
use App\Models\LiveVideo;
use Illuminate\Http\JsonResponse;

class AppApiController extends Controller
{
    /**
     * Get all active hero slides for homepage
     * GET /api/hero-slides
     */
    public function getHeroSlides(): JsonResponse
    {
        $slides = HeroSlide::active()
            ->ordered()
            ->get()
            ->map(function ($slide) {
                return [
                    'id' => $slide->id,
                    'title' => $slide->title,
                    'description' => $slide->description,
                    'image_url' => $slide->image_url,
                    'image_download_url' => $slide->image_download_url,
                    'button_text' => $slide->button_text,
                    'button_link' => $slide->button_link,
                    'order' => $slide->order,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Hero slides retrieved successfully',
            'data' => $slides
        ]);
    }

    /**
     * Get splash screen image
     * GET /api/splash-screen
     */
    public function getSplashScreen(): JsonResponse
    {
        $setting = AppSetting::where('key', 'splash_screen_image')->first();

        $data = [
            'has_splash_screen' => !empty($setting->value),
            'image_url' => $setting->value ? url(\Illuminate\Support\Facades\Storage::url($setting->value)) : null,
            'image_download_url' => $setting->value ? url(\Illuminate\Support\Facades\Storage::url($setting->value)) : null,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Splash screen retrieved successfully',
            'data' => $data
        ]);
    }

    /**
     * Get live videos
     * GET /api/live-videos
     */
    public function getLiveVideos(): JsonResponse
    {
        $videos = LiveVideo::active()
            ->ordered()
            ->get()
            ->map(function ($video) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'youtube_url' => $video->youtube_url,
                    'youtube_video_id' => $video->youtube_video_id,
                    'embed_url' => $video->embed_url,
                    'thumbnail_url' => $video->thumbnail_url,
                    'scheduled_at' => $video->scheduled_at?->toIso8601String(),
                    'status' => $video->status,
                    'is_live_now' => $video->is_live_now,
                    'is_upcoming' => $video->is_upcoming,
                    'order' => $video->order,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Live videos retrieved successfully',
            'data' => $videos
        ]);
    }

    /**
     * Get currently live videos only
     * GET /api/live-videos/current
     */
    public function getCurrentLiveVideos(): JsonResponse
    {
        $videos = LiveVideo::active()
            ->live()
            ->ordered()
            ->get()
            ->map(function ($video) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'youtube_url' => $video->youtube_url,
                    'youtube_video_id' => $video->youtube_video_id,
                    'embed_url' => $video->embed_url,
                    'thumbnail_url' => $video->thumbnail_url,
                    'scheduled_at' => $video->scheduled_at?->toIso8601String(),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Current live videos retrieved successfully',
            'data' => $videos
        ]);
    }
}
