<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('courses')
            ->orderBy('name')
            ->get();

        return view('front.pages.categories.index', compact('categories'));
    }
}
