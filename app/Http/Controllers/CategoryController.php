<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\HandleDataLoading;

class CategoryController extends Controller
{
    private HandleDataLoading $handleDataLoading;

    public function __construct(HandleDataLoading $handleDataLoading)
    {
        $this->handleDataLoading = $handleDataLoading;
    }

    public function index()
    {
        return $this->handleDataLoading->handleCollection(function () {
            return Category::all();
        }, 'categories');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $category = Category::create($validated);
        return response()->json(['message' => 'Category created', 'category' => $category] ,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($category)
    {
        $category = Category::find($category);
        if (!$category) return response()->json(['message' => 'Category not found'], 404);
        return response()->json($category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        try {
            $category->update($validated);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating category', 'error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Category updated', 'category' => $category]);
    }


    public function destroy($category)
    {
        $category = Category::find($category);
        $this->handleDataLoading->handleDestroy($category, 'category', 'delete');
    }
}
