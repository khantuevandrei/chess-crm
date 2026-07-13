<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainerController extends Controller
{
    /**
     * Display a list of trainers with KPI cards.
     */
    public function index()
    {
        $trainersThisMonth = Trainer::whereMonth('created_at', now()->month)->count();
        $trainersLastMonth = Trainer::whereMonth('created_at', now()->subMonth()->month)->count();
        $trainerChange = $trainersThisMonth - $trainersLastMonth;

        return Inertia::render('Trainers/Index', [
            'trainers' => Trainer::with('branch')
                ->withCount(['students', 'lessons'])
                ->orderBy('last_name')->get(),
            'branches' => Branch::orderBy('name')->get(),
            'stats' => [
                ['title' => 'Trainers', 'value' => Trainer::count(), 'change' => ($trainerChange >= 0 ? '+' : '').$trainerChange.' this month', 'icon' => 'pi pi-user', 'color' => 'purple', 'positive' => true],
                ['title' => 'Active Today', 'value' => Lesson::whereDate('start_time', today())->distinct('trainer_id')->count(), 'change' => 'Teaching today', 'icon' => 'pi pi-calendar', 'color' => 'blue', 'positive' => false],
                ['title' => 'Students', 'value' => Student::count(), 'change' => 'Total students', 'icon' => 'pi pi-users', 'color' => 'green', 'positive' => false],
                ['title' => 'Avg Load', 'value' => Trainer::has('lessons')->count() > 0 ? round(Trainer::count() / max(Trainer::has('lessons')->count(), 1) * 100).'%' : 'N/A', 'change' => 'Active trainers', 'icon' => 'pi pi-chart-bar', 'color' => 'orange', 'positive' => false],
                ['title' => 'Week Lessons', 'value' => Lesson::whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])->count(), 'change' => 'This week', 'icon' => 'pi pi-calendar-clock', 'color' => 'yellow', 'positive' => false],
                ['title' => 'Avg Rating', 'value' => Trainer::whereNotNull('rating')->avg('rating') ? round(Trainer::whereNotNull('rating')->avg('rating'), 1) : 'N/A', 'change' => 'Out of 5', 'icon' => 'pi pi-star', 'color' => 'gold', 'positive' => false],
            ],
        ]);
    }

    /**
     * Show the form for creating a new trainer.
     */
    public function create()
    {
        return Inertia::render('Trainers/Create', [
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created trainer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|unique:trainers,email',
            'phone' => 'required|string|max:20|unique:trainers,phone',
            'specialization' => 'required|string|max:20',
            'rating' => 'nullable|integer',
            'status' => 'nullable|in:active,inactive',
            'branch_id' => 'required|exists:branches,id',
            'bio' => 'nullable|string|max:500',
        ]);

        $trainer = Trainer::create($validated);

        return redirect()->route('trainers.show', $trainer)->with('success', 'Trainer created.');
    }

    /**
     * Display the specified trainer.
     */
    public function show(Trainer $trainer)
    {
        $trainer->loadCount(['students', 'lessons']);
        $trainer->load('branch');

        return Inertia::render('Trainers/Show', [
            'trainer' => $trainer,
        ]);
    }

    /**
     * Show the form for editing the specified trainer.
     */
    public function edit(Trainer $trainer)
    {
        return Inertia::render('Trainers/Edit', [
            'trainer' => $trainer,
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified trainer in storage.
     */
    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|unique:trainers,email,'.$trainer->id,
            'phone' => 'required|string|max:20|unique:trainers,phone,'.$trainer->id,
            'specialization' => 'required|string|max:20',
            'rating' => 'nullable|integer',
            'status' => 'nullable|in:active,inactive',
            'branch_id' => 'nullable|exists:branches,id',
            'bio' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $trainer->update($validated);

        return redirect()->route('trainers.show', $trainer)->with('success', 'Trainer updated.');
    }

    /**
     * Remove the specified trainer from storage.
     */
    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return back()->with('success', 'Trainer deleted.');
    }
}
