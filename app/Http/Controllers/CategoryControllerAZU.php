<?php

namespace App\Http\Controllers;

use App\Models\CategoryAZU;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryControllerAZU extends Controller
{
    public function index(): View
    {
        return view('categories.index', [
            'categories' => CategoryAZU::withCount('tasks')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('categories.create', ['category' => new CategoryAZU()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        CategoryAZU::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(CategoryAZU $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, CategoryAZU $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$category->id],
        ]);

        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(CategoryAZU $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
