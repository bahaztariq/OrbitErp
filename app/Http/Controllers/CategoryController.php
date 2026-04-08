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
        $categories = $company->categories;
        return view('categories.index', compact('categories', 'company'));
    }

    public function create(Company $company)
    {
        return view('categories.create', compact('company'));
    }

    public function store(StoreCategoryRequest $request, Company $company)
    {
        $category = $company->categories()->create($request->validated());
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category created successfully');
    }

    public function show(Company $company, Category $category)
    {
        return view('categories.show', compact('category', 'company'));
    }

    public function edit(Company $company, Category $category)
    {
        return view('categories.edit', compact('category', 'company'));
    }

    public function update(UpdateCategoryRequest $request, Company $company, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Company $company, Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $category = $company->categories()->onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $category = $company->categories()->onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('categories.index', $company->slug)
            ->with('success', 'Category permanently deleted');
    }
}
