<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Company;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $this->authorize('viewAny', Category::class);
        $categories = $company->categories;
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request, Company $company)
    {
        $this->authorize('create', Category::class);
        $category = $company->categories()->create($request->validated());

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Category $category)
    {
        $this->authorize('view', $category);
        return response()->json([
            'message' => 'Category retrieved successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Company $company, Category $category)
    {
        $this->authorize('update', $category);
        $category->update($request->validated());

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $category = $company->categories()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $category);
        $category->restore();

        return response()->json([
            'message' => 'Category restored successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $category = $company->categories()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $category);
        $category->forceDelete();

        return response()->json([
            'message' => 'Category permanently deleted'
        ], 200);
    }
}