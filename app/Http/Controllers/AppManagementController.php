<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\AppSetting;
use App\Models\LiveVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppManagementController extends Controller
{
    // ==================== APP MANAGEMENT INDEX ====================
    
    public function index()
    {
        return view('app-management.index');
    }
    
    // ==================== HERO SLIDES ====================
    
    public function heroIndex()
    {
        $slides = HeroSlide::ordered()->get();
        return view('app-management.hero.index', compact('slides'));
    }

    public function heroCreate()
    {
        return view('app-management.hero.create');
    }

    public function heroStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        HeroSlide::create($validated);

        return redirect()->route('app.hero.index')->with('success', 'Hero slide created successfully!');
    }

    public function heroEdit(HeroSlide $slide)
    {
        return view('app-management.hero.edit', compact('slide'));
    }

    public function heroUpdate(Request $request, HeroSlide $slide)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slide->image_path) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $slide->update($validated);

        return redirect()->route('app.hero.index')->with('success', 'Hero slide updated successfully!');
    }

    public function heroDestroy(HeroSlide $slide)
    {
        // Delete image
        if ($slide->image_path) {
            Storage::disk('public')->delete($slide->image_path);
        }

        $slide->delete();

        return redirect()->route('app.hero.index')->with('success', 'Hero slide deleted successfully!');
    }

    // ==================== SPLASH SCREEN ====================
    
    public function splashIndex()
    {
        $splashScreen = AppSetting::where('key', 'splash_screen_image')->first();
        return view('app-management.splash.index', compact('splashScreen'));
    }

    public function splashUpdate(Request $request)
    {
        $request->validate([
            'splash_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $setting = AppSetting::where('key', 'splash_screen_image')->first();

        if ($request->hasFile('splash_image')) {
            // Delete old splash screen
            if ($setting->value) {
                Storage::disk('public')->delete($setting->value);
            }

            $imagePath = $request->file('splash_image')->store('splash-screen', 'public');
            $setting->value = $imagePath;
            $setting->save();
        }

        return redirect()->route('app.splash.index')->with('success', 'Splash screen updated successfully!');
    }

    public function splashDelete()
    {
        $setting = AppSetting::where('key', 'splash_screen_image')->first();

        if ($setting->value) {
            Storage::disk('public')->delete($setting->value);
            $setting->value = null;
            $setting->save();
        }

        return redirect()->route('app.splash.index')->with('success', 'Splash screen deleted successfully!');
    }

    // ==================== LIVE VIDEOS ====================
    
    public function liveIndex()
    {
        $liveVideos = LiveVideo::ordered()->get();
        return view('app-management.live.index', compact('liveVideos'));
    }

    public function liveCreate()
    {
        return view('app-management.live.create');
    }

    public function liveStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'scheduled_at' => 'nullable|date',
            'status' => 'required|in:upcoming,live,ended',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        LiveVideo::create($validated);

        return redirect()->route('app.live.index')->with('success', 'Live video added successfully!');
    }

    public function liveEdit(LiveVideo $video)
    {
        return view('app-management.live.edit', compact('video'));
    }

    public function liveUpdate(Request $request, LiveVideo $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'scheduled_at' => 'nullable|date',
            'status' => 'required|in:upcoming,live,ended',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $video->update($validated);

        return redirect()->route('app.live.index')->with('success', 'Live video updated successfully!');
    }

    public function liveDestroy(LiveVideo $video)
    {
        $video->delete();
        return redirect()->route('app.live.index')->with('success', 'Live video deleted successfully!');
    }
}
