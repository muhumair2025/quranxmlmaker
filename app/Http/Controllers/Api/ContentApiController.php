<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Content;
use Illuminate\Http\JsonResponse;

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
        }

        return response()->json([
            'success' => true,
            'message' => 'Content retrieved successfully',
            'data' => $data
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
