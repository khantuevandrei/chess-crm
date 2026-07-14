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
        $now = now();
        $todayLessons = Lesson::whereDate('start_time', today())->count();
        $nowLessons = Lesson::where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->count();
        $weekLessons = Lesson::whereBetween('start_time', [$now->startOfWeek(), $now->endOfWeek()])->count();
        $cancelledLessons = Lesson::where('status', 'cancelled')
            ->whereBetween('start_time', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        return Inertia::render('Lessons/Index', [
            'lessons' => Lesson::with(['trainer', 'student', 'branch'])
                ->orderBy('start_time')->get(),
            'trainers' => Trainer::orderBy('last_name')->get(),
            'students' => Student::orderBy('last_name')->get(),
            'branches' => Branch::orderBy('name')->get(),
            'stats' => [
                ['title' => 'Today', 'value' => $todayLessons, 'change' => 'Lessons scheduled', 'icon' => 'pi pi-calendar', 'color' => 'purple', 'positive' => false],
                ['title' => 'Now', 'value' => $nowLessons, 'change' => 'In progress', 'icon' => 'pi pi-play-circle', 'color' => 'green', 'positive' => false],
                ['title' => 'This Week', 'value' => $weekLessons, 'change' => 'Total lessons', 'icon' => 'pi pi-calendar-clock', 'color' => 'blue', 'positive' => false],
                ['title' => 'Attendance', 'value' => '94%', 'change' => 'Average this month', 'icon' => 'pi pi-check-circle', 'color' => 'orange', 'positive' => false],
                ['title' => 'Cancelled', 'value' => $cancelledLessons, 'change' => 'This month', 'icon' => 'pi pi-times-circle', 'color' => 'red', 'positive' => false],
                ['title' => 'Avg Load', 'value' => Trainer::has('lessons')->count() > 0 ? round(Lesson::whereBetween('start_time', [$now->startOfWeek(), $now->endOfWeek()])->count() / Trainer::has('lessons')->count(), 1) : 'N/A', 'change' => 'Lessons per trainer', 'icon' => 'pi pi-chart-bar', 'color' => 'yellow', 'positive' => false],
            ],
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

    public function create()
    {
        return Inertia::render('Lessons/Create', [
            'trainers' => Trainer::orderBy('last_name')->get(),
            'students' => Student::orderBy('last_name')->get(),
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }

    public function edit(Lesson $lesson)
    {
        return Inertia::render('Lessons/Edit', [
            'lesson' => $lesson->load(['trainer', 'student', 'branch']),
            'trainers' => Trainer::orderBy('last_name')->get(),
            'students' => Student::orderBy('last_name')->get(),
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }

    public function show(Lesson $lesson)
    {
        $lesson->load(['trainer', 'student', 'branch']);
        $lesson->loadCount('students');

        return Inertia::render('Lessons/Show', [
            'lesson' => $lesson,
        ]);
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
