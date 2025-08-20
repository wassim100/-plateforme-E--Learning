<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));
        $perPage = (int)$request->get('per', 15);
        // clamp per page to a reasonable range
        $perPage = max(5, min($perPage, 100));

    // Build query via model instance to satisfy certain linters
    $query = (new Category())->newQuery();
        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('slug', 'like', "%$q%");
            });
        }

    $categories = $query
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        // small KPIs for the toolbar
    $base = (new Category())->newQuery();
    $total = (clone $base)->count();
    $activeCount = (clone $base)->where('is_active', true)->count();
        $inactiveCount = max(0, $total - $activeCount);

    return View::make('admin.pages.categories.index', compact('categories','q','perPage','total','activeCount','inactiveCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return View::make('admin.pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:120|unique:categories,slug',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? false);
        $category = new Category();
        $category->fill($data);
        $category->save();
    return Redirect::route('admin.categories.index')->with('status', 'Catégorie créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
    return View::make('admin.pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $id = $category->id;
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:120|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? false);
        $category->fill($data);
        $category->save();
    return Redirect::route('admin.categories.index')->with('status', 'Catégorie mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
    $category->delete();
    return Redirect::route('admin.categories.index')->with('status', 'Catégorie supprimée');
    }
}
