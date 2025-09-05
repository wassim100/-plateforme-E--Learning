<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Base query with category and quizzes count for cards
        $query = (new Course())->newQuery()
            ->with('category')
            ->withCount('quizzes');

        // Optional category filter (?category=<id>)
        $activeCategory = null;
        $categoryId = (int) $request->get('category');
        if ($categoryId > 0) {
            $activeCategory = (new Category())->newQuery()->find($categoryId);
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

    // Paginate for a Coursera-like experience
        $courses = $query->paginate(12)->withQueryString();

    $allCategories = (new Category())->newQuery()->where('is_active', true)->orderBy('name')->get(['id','name']);
    return view('front.pages.courses.index', compact('courses', 'activeCategory', 'allCategories'));
    }
}
