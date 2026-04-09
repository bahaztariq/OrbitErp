<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Company $company)
    {
        $this->authorize('viewAny', Category::class);
        $categories = $company->categories;
        return view('categories.index', compact('categories', 'company'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', Category::class);
        return view('categories.create', compact('company'));
    }

    public function store(StoreCategoryRequest $request, Company $company)
    {
        $this->authorize('create', Category::class);
        $category = $company->categories()->create($request->validated());
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category created successfully');
    }

    public function show(Company $company, Category $category)
    {
        $this->authorize('view', $category);
        return view('categories.show', compact('category', 'company'));
    }

    public function edit(Company $company, Category $category)
    {
        $this->authorize('view', $category);
        return view('categories.edit', compact('category', 'company'));
    }

    public function update(UpdateCategoryRequest $request, Company $company, Category $category)
    {
        $this->authorize('update', $category);
        $category->update($request->validated());
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Company $company, Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $category = $company->categories()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $category);
        $category->restore();
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $category = $company->categories()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $category);
        $category->forceDelete();
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category permanently deleted');
    }
}