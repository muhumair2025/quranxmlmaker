<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentApiController extends Controller
{
    /**
     * Get all active categories (Main cards for homepage)
     * GET /api/categories
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::active()
            ->ordered()
            ->with(['iconLibrary'])
            ->withCount(['activeSubcategories'])
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'names' => [
                        'english' => $category->name_english,
                        'urdu' => $category->name_urdu,
                        'arabic' => $category->name_arabic,
                        'pashto' => $category->name_pashto,
                    ],
                    'description' => $category->description,
                    'icon_url' => $category->icon_url,
                    'color' => $category->color,
                    'subcategories_count' => $category->active_subcategories_count,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ]);
    }

    /**
     * Get single category with its subcategories
     * GET /api/categories/{id}
     */
    public function getCategory($id): JsonResponse
    {
        $category = Category::active()
            ->with(['iconLibrary', 'activeSubcategories' => function ($query) {
                $query->withCount(['activeContents']);
            }])
            ->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $data = [
            'id' => $category->id,
            'names' => [
                'english' => $category->name_english,
                'urdu' => $category->name_urdu,
                'arabic' => $category->name_arabic,
                'pashto' => $category->name_pashto,
            ],
            'description' => $category->description,
            'icon_url' => $category->icon_url,
            'color' => $category->color,
            'subcategories' => $category->activeSubcategories->map(function ($subcategory) {
                return [
                    'id' => $subcategory->id,
                    'name' => $subcategory->name,
                    'description' => $subcategory->description,
                    'contents_count' => $subcategory->active_contents_count,
                ];
            })
        ];

        return response()->json([
            'success' => true,
            'message' => 'Category retrieved successfully',
            'data' => $data
        ]);
    }

    /**
     * Get subcategory with its contents
     * GET /api/subcategories/{id}
     */
    public function getSubcategory($id): JsonResponse
    {
        $subcategory = Subcategory::active()
            ->with(['category.iconLibrary', 'activeContents'])
            ->find($id);

        if (!$subcategory) {
            return response()->json([
                'success' => false,
                'message' => 'Subcategory not found'
            ], 404);
        }

        $data = [
            'id' => $subcategory->id,
            'name' => $subcategory->name,
            'description' => $subcategory->description,
            'category' => [
                'id' => $subcategory->category->id,
                'names' => [
                    'english' => $subcategory->category->name_english,
                    'urdu' => $subcategory->category->name_urdu,
                    'arabic' => $subcategory->category->name_arabic,
                    'pashto' => $subcategory->category->name_pashto,
                ],
                'icon_url' => $subcategory->category->icon_url,
                'color' => $subcategory->category->color,
            ],
            'contents' => $subcategory->activeContents->map(function ($content) {
                $contentData = [
                    'id' => $content->id,
                    'type' => $content->type,
                    'title' => $content->title,
                ];

                // Add type-specific data
                switch ($content->type) {
                    case 'text':
                        $contentData['text_content'] = $content->text_content;
                        break;
                    case 'qa':
                        $contentData['question'] = $content->question;
                        $contentData['answer'] = $content->answer;
                        break;
                    case 'pdf':
                        $contentData['pdf_url'] = $content->pdf_url;
                        break;
                    case 'audio':
                        $contentData['audio_url'] = $content->audio_url;
                        break;
                    case 'video':
                        $contentData['video_url'] = $content->video_url;
                        break;
                }

                return $contentData;
            })
        ];

        return response()->json([
            'success' => true,
            'message' => 'Subcategory retrieved successfully',
            'data' => $data
        ]);
    }

    /**
     * Get single content item
     * GET /api/contents/{id}
     */
    public function getContent($id): JsonResponse
    {
        $content = Content::active()
            ->with(['subcategory.category.iconLibrary'])
            ->find($id);

        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found'
            ], 404);
        }

        $data = [
            'id' => $content->id,
            'type' => $content->type,
            'title' => $content->title,
            'subcategory' => [
                'id' => $content->subcategory->id,
                'name' => $content->subcategory->name,
            ],
            'category' => [
                'id' => $content->subcategory->category->id,
                'names' => [
                    'english' => $content->subcategory->category->name_english,
                    'urdu' => $content->subcategory->category->name_urdu,
                    'arabic' => $content->subcategory->category->name_arabic,
                    'pashto' => $content->subcategory->category->name_pashto,
                ],
                'icon_url' => $content->subcategory->category->icon_url,
                'color' => $content->subcategory->category->color,
            ]
        ];

        // Add type-specific data
        switch ($content->type) {
            case 'text':
                $data['text_content'] = $content->text_content;
                break;
            case 'qa':
                $data['question'] = $content->question;
                $data['answer'] = $content->answer;
                break;
            case 'pdf':
                $data['pdf_url'] = $content->pdf_url;
                break;
            case 'audio':
                $data['audio_url'] = $content->audio_url;
                break;
            case 'video':
                $data['video_url'] = $content->video_url;
                break;
        }

        return response()->json([
            'success' => true,
            'message' => 'Content retrieved successfully',
            'data' => $data
        ]);
    }

    /**
     * Get latest content from across the system
     * GET /api/latest
     */
    public function getLatest(Request $request): JsonResponse
    {
        $types = $request->get('types') ? explode(',', $request->get('types')) : null;
        $limit = (int) $request->get('limit', 50);
        $offset = (int) $request->get('offset', 0);

        $items = [];

        // Get latest categories
        if (!$types || in_array('category', $types)) {
            $categories = Category::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'type' => 'category',
                        'title' => $category->name_english,
                        'subtitle' => null,
                        'description' => $category->description,
                        'image_url' => $category->icon_url,
                        'content_url' => null,
                        'created_at' => $category->created_at->toIso8601String(),
                        'updated_at' => $category->updated_at?->toIso8601String(),
                        'category_id' => $category->id,
                        'category_name' => $category->name_english,
                        'category_color' => $category->color,
                        'subcategory_id' => null,
                        'subcategory_name' => null,
                        'surah_number' => null,
                        'ayah_number' => null,
                        'surah_name' => null,
                        'section_type' => null,
                    ];
                });
            $items = array_merge($items, $categories->toArray());
        }

        // Get latest subcategories
        if (!$types || in_array('subcategory', $types)) {
            $subcategories = Subcategory::with('category')
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get()
                ->map(function ($subcategory) {
                    return [
                        'id' => $subcategory->id,
                        'type' => 'subcategory',
                        'title' => $subcategory->name,
                        'subtitle' => null,
                        'description' => $subcategory->description,
                        'image_url' => null,
                        'content_url' => null,
                        'created_at' => $subcategory->created_at->toIso8601String(),
                        'updated_at' => $subcategory->updated_at?->toIso8601String(),
                        'category_id' => $subcategory->category->id,
                        'category_name' => $subcategory->category->name_english,
                        'category_color' => $subcategory->category->color,
                        'subcategory_id' => $subcategory->id,
                        'subcategory_name' => $subcategory->name,
                        'surah_number' => null,
                        'ayah_number' => null,
                        'surah_name' => null,
                        'section_type' => null,
                    ];
                });
            $items = array_merge($items, $subcategories->toArray());
        }

        // Get latest content (text, qa, pdf, audio, video)
        $contentTypes = ['text', 'qa', 'pdf', 'audio', 'video'];
        $filteredContentTypes = $types ? array_intersect($contentTypes, $types) : $contentTypes;

        if (!empty($filteredContentTypes)) {
            $contents = Content::with(['subcategory.category'])
                ->where('is_active', true)
                ->whereIn('type', $filteredContentTypes)
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get()
                ->map(function ($content) {
                    // Get content URL based on type
                    $contentUrl = null;
                    $description = null;

                    switch ($content->type) {
                        case 'text':
                            $description = substr(strip_tags($content->text_content), 0, 200);
                            break;
                        case 'qa':
                            $description = $content->question;
                            break;
                        case 'pdf':
                            $contentUrl = $content->pdf_url;
                            $description = 'PDF Document';
                            break;
                        case 'audio':
                            $contentUrl = $content->audio_url;
                            $description = 'Audio File';
                            break;
                        case 'video':
                            $contentUrl = $content->video_url;
                            $description = 'Video File';
                            break;
                    }

                    return [
                        'id' => $content->id,
                        'type' => $content->type,
                        'title' => $content->title,
                        'subtitle' => null,
                        'description' => $description,
                        'image_url' => null,
                        'content_url' => $contentUrl,
                        'created_at' => $content->created_at->toIso8601String(),
                        'updated_at' => $content->updated_at?->toIso8601String(),
                        'category_id' => $content->subcategory->category->id,
                        'category_name' => $content->subcategory->category->name_english,
                        'category_color' => $content->subcategory->category->color,
                        'subcategory_id' => $content->subcategory->id,
                        'subcategory_name' => $content->subcategory->name,
                        'surah_number' => null,
                        'ayah_number' => null,
                        'surah_name' => null,
                        'section_type' => null,
                    ];
                });
            $items = array_merge($items, $contents->toArray());
        }

        // Sort all items by created_at descending
        usort($items, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // Apply pagination
        $totalCount = count($items);
        $items = array_slice($items, $offset, $limit);

        return response()->json([
            'success' => true,
            'message' => 'Latest content retrieved successfully',
            'total_count' => count($items),
            'total_available' => $totalCount,
            'last_updated' => now()->toIso8601String(),
            'data' => $items
        ]);
    }

    /**
     * Search content across all categories
     * GET /api/search?q={query}
     */
    public function search(): JsonResponse
    {
        $query = request('q');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required'
            ], 400);
        }

        $contents = Content::active()
            ->with(['subcategory.category.iconLibrary'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('text_content', 'like', "%{$query}%")
                    ->orWhere('question', 'like', "%{$query}%")
                    ->orWhere('answer', 'like', "%{$query}%");
            })
            ->orderBy('order')
            ->get()
            ->map(function ($content) {
                $contentData = [
                    'id' => $content->id,
                    'type' => $content->type,
                    'title' => $content->title,
                    'subcategory' => [
                        'id' => $content->subcategory->id,
                        'name' => $content->subcategory->name,
                    ],
                    'category' => [
                        'id' => $content->subcategory->category->id,
                        'names' => [
                            'english' => $content->subcategory->category->name_english,
                            'urdu' => $content->subcategory->category->name_urdu,
                            'arabic' => $content->subcategory->category->name_arabic,
                            'pashto' => $content->subcategory->category->name_pashto,
                        ],
                        'icon_url' => $content->subcategory->category->icon_url,
                        'color' => $content->subcategory->category->color,
                    ]
                ];

                // Add preview based on type
                switch ($content->type) {
                    case 'text':
                        $contentData['preview'] = substr(strip_tags($content->text_content), 0, 150) . '...';
                        break;
                    case 'qa':
                        $contentData['preview'] = $content->question;
                        break;
                    case 'pdf':
                        $contentData['preview'] = 'PDF Document';
                        break;
                    case 'audio':
                        $contentData['preview'] = 'Audio File';
                        break;
                    case 'video':
                        $contentData['preview'] = 'Video File';
                        break;
                }

                return $contentData;
            });

        return response()->json([
            'success' => true,
            'message' => 'Search completed successfully',
            'query' => $query,
            'results_count' => $contents->count(),
            'data' => $contents
        ]);
    }
}
