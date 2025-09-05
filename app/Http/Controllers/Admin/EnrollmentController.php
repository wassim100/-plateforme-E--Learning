<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['user', 'course'])->latest()->paginate(10);
        return view('admin.pages.enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'student')->orderBy('name')->get();
        $courses = Course::orderBy('title')->get();
        return view('admin.pages.enrollments.create', compact('users', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('enrollments')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id)
                                 ->where('course_id', $request->course_id);
                }),
            ],
            'course_id' => 'required|exists:courses,id',
        ], [
            'user_id.unique' => 'Cet étudiant est déjà inscrit à ce cours.'
        ]);

        Enrollment::create($request->all());

        return redirect()->route('admin.enrollments.index')->with('success', 'Inscription créée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('admin.enrollments.index')->with('success', 'Inscription annulée avec succès.');
    }
}
