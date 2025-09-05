<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));
        $query = Course::query()->with('category');
        if ($q !== '') {
            $query->where('title', 'like', "%$q%");
        }
        $courses = $query->get();
        return view('admin.pages.courses.index', compact('courses','q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title','description','price','category_id']);

        /** @var UploadedFile|null $image */
        $image = $request->file('image');
        if ($image) {
            $data['image'] = $image->store('courses', 'public');
        }

        Course::create($data);

        return Redirect::route('admin.courses.index')
            ->with('success', 'Cours créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('admin.pages.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('admin.pages.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title','description','price','category_id']);

        /** @var UploadedFile|null $image */
        $image = $request->file('image');
        if ($image) {
            // Delete old image
            if ($course->image) {
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = Storage::disk('public');
                $disk->delete($course->image);
            }
            $data['image'] = $image->store('courses', 'public');
        }

        $course->fill($data);
        $course->save();

        return Redirect::route('admin.courses.index')
            ->with('success', 'Cours mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->image) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk('public');
            $disk->delete($course->image);
        }
        $course->delete();

        return Redirect::route('admin.courses.index')
            ->with('success', 'Cours supprimé avec succès.');
    }
}
