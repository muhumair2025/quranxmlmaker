<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentManagementController extends Controller
{
    // ==================== DASHBOARD ====================
    
    public function index()
    {
        $stats = [
            'categories' => Category::count(),
            'subcategories' => Subcategory::count(),
            'contents' => Content::count(),
            'active_contents' => Content::where('is_active', true)->count(),
        ];

        $recentContents = Content::with(['subcategory.category'])
            ->latest()
            ->take(10)
            ->get();

        return view('content-management.index', compact('stats', 'recentContents'));
    }

    // ==================== CATEGORIES ====================
    
    public function categoriesIndex()
    {
        $categories = Category::with(['iconLibrary'])->withCount(['subcategories'])->ordered()->get();
        return view('content-management.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('content-management.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $validated = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_urdu' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_pashto' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_library_id' => 'nullable|exists:icon_library,id',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['order'] = $validated['order'] ?? Category::max('order') + 1;
        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);

        return redirect()
            ->route('content.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function categoriesEdit(Category $category)
    {
        return view('content-management.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_urdu' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_pashto' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_library_id' => 'nullable|exists:icon_library,id',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()
            ->route('content.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function categoriesDestroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('content.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    // ==================== SUBCATEGORIES ====================
    
    public function subcategoriesIndex()
    {
        // Group subcategories by category for collapsible view
        $categories = Category::with(['activeSubcategories' => function ($query) {
                $query->withCount(['contents'])->ordered();
            }])
            ->withCount(['activeSubcategories'])
            ->ordered()
            ->get();
            
        return view('content-management.subcategories.index', compact('categories'));
    }

    public function subcategoriesCreate()
    {
        $categories = Category::active()->ordered()->get();
        return view('content-management.subcategories.create', compact('categories'));
    }

    public function subcategoriesStore(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['order'] = $validated['order'] ?? Subcategory::where('category_id', $validated['category_id'])->max('order') + 1;
        $validated['is_active'] = $request->has('is_active');

        Subcategory::create($validated);

        return redirect()
            ->route('content.subcategories.index')
            ->with('success', 'Subcategory created successfully!');
    }

    public function subcategoriesEdit(Subcategory $subcategory)
    {
        $categories = Category::active()->ordered()->get();
        return view('content-management.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function subcategoriesUpdate(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $subcategory->update($validated);

        return redirect()
            ->route('content.subcategories.index')
            ->with('success', 'Subcategory updated successfully!');
    }

    public function subcategoriesDestroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()
            ->route('content.subcategories.index')
            ->with('success', 'Subcategory deleted successfully!');
    }

    // ==================== CONTENTS ====================
    
    public function contentsIndex()
    {
        $contents = Content::with(['subcategory.category'])
            ->ordered()
            ->paginate(20);
        return view('content-management.contents.index', compact('contents'));
    }

    public function contentsCreate()
    {
        $categories = Category::active()->with(['activeSubcategories'])->ordered()->get();
        return view('content-management.contents.create', compact('categories'));
    }

    public function contentsStore(Request $request)
    {
        $validated = $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'type' => 'required|in:text,qa,pdf',
            'title' => 'required|string|max:255',
            'text_content' => 'required_if:type,text|nullable|string',
            'question' => 'required_if:type,qa|nullable|string',
            'answer' => 'required_if:type,qa|nullable|string',
            'pdf_url' => 'required_if:type,pdf|nullable|url|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['order'] = $validated['order'] ?? Content::where('subcategory_id', $validated['subcategory_id'])->max('order') + 1;
        $validated['is_active'] = $request->has('is_active');

        Content::create($validated);

        return redirect()
            ->route('content.contents.index')
            ->with('success', 'Content created successfully!');
    }

    public function contentsEdit(Content $content)
    {
        $categories = Category::active()->with(['activeSubcategories'])->ordered()->get();
        return view('content-management.contents.edit', compact('content', 'categories'));
    }

    public function contentsUpdate(Request $request, Content $content)
    {
        $validated = $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'type' => 'required|in:text,qa,pdf',
            'title' => 'required|string|max:255',
            'text_content' => 'required_if:type,text|nullable|string',
            'question' => 'required_if:type,qa|nullable|string',
            'answer' => 'required_if:type,qa|nullable|string',
            'pdf_url' => 'required_if:type,pdf|nullable|url|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $content->update($validated);

        return redirect()
            ->route('content.contents.index')
            ->with('success', 'Content updated successfully!');
    }

    public function contentsDestroy(Content $content)
    {
        $content->delete();

        return redirect()
            ->route('content.contents.index')
            ->with('success', 'Content deleted successfully!');
    }
}
