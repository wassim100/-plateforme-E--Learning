<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = Answer::with('question')->get();
        return view('admin.pages.answers.index', compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all();
        return view('admin.pages.answers.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'answer_text' => 'required|string',
            'question_id' => 'required|exists:questions,id',
            'is_correct' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_correct'] = $request->has('is_correct');

        Answer::create($data);

        return redirect()->route('admin.answers.index')
            ->with('success', 'Réponse créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        return view('admin.pages.answers.show', compact('answer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        $questions = Question::all();
        return view('admin.pages.answers.edit', compact('answer', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'answer_text' => 'required|string',
            'question_id' => 'required|exists:questions,id',
            'is_correct' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_correct'] = $request->has('is_correct');

        $answer->update($data);

        return redirect()->route('admin.answers.index')
            ->with('success', 'Réponse mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();

        return redirect()->route('admin.answers.index')
            ->with('success', 'Réponse supprimée avec succès.');
    }
}
