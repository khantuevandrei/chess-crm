<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function index()
    {
        return Inertia::render('Lessons/Index', [
            'lessons' => Lesson::with('trainer', 'student', 'branch')->orderBy('start_time')->get(),
            'trainers' => Trainer::orderBy('last_name')->get(),
            'students' => Student::orderBy('last_name')->get(),
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'student_id' => 'nullable|exists:students,id',
            'branch_id' => 'required|exists:branches,id',
            'type' => 'required|in:individual,group',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'nullable|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        Lesson::create($validated);

        return redirect()->route('lessons.index')->with('success', 'Lesson created.');
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'student_id' => 'nullable|exists:students,id',
            'branch_id' => 'required|exists:branches,id',
            'type' => 'required|in:individual,group',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'nullable|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $lesson->update($validated);

        return redirect()->route('lessons.index')->with('success', 'Lesson updated.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return back()->with('success', 'Lesson deleted.');
    }
}
