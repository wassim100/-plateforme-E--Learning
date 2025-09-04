<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('quiz')->get();
        return view('admin.pages.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quizzes = Quiz::all();
        return view('admin.pages.questions.create', compact('quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        Question::create($request->all());

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return view('admin.pages.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('admin.pages.questions.edit', compact('question', 'quizzes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        $question->update($request->all());

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question supprimée avec succès.');
    }
}
