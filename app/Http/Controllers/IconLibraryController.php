<?php

namespace App\Http\Controllers;

use App\Models\IconLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IconLibraryController extends Controller
{
    /**
     * Display icon library.
     */
    public function index()
    {
        $icons = IconLibrary::latest()->get();
        return view('icon-library.index', compact('icons'));
    }

    /**
     * Show upload form.
     */
    public function create()
    {
        return view('icon-library.create');
    }

    /**
     * Store uploaded icon.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon_file' => 'required|file|mimes:png,jpg,jpeg,svg,webp|max:2048' // 2MB max
        ]);

        $file = $request->file('icon_file');
        $path = $file->store('icons', 'public');
        
        IconLibrary::create([
            'name' => $validated['name'],
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'original_name' => $file->getClientOriginalName()
        ]);

        return redirect()
            ->route('icon-library.index')
            ->with('success', 'Icon uploaded successfully!');
    }

    /**
     * Delete icon from library.
     */
    public function destroy(IconLibrary $icon)
    {
        // Check if icon is in use
        if ($icon->isInUse()) {
            return redirect()
                ->route('icon-library.index')
                ->with('error', 'Cannot delete icon that is currently in use by categories.');
        }

        // Delete file from storage
        if ($icon->file_path) {
            Storage::disk('public')->delete($icon->file_path);
        }

        $icon->delete();

        return redirect()
            ->route('icon-library.index')
            ->with('success', 'Icon deleted successfully!');
    }
}
