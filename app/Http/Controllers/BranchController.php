<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{
    public function index()
    {
        $studentsThisMonth = Student::whereMonth('created_at', now()->month)->count();
        $studentsLastMonth = Student::whereMonth('created_at', now()->subMonth()->month)->count();
        $studentChange = $studentsThisMonth - $studentsLastMonth;

        $trainersThisMonth = Trainer::whereMonth('created_at', now()->month)->count();
        $trainersLastMonth = Trainer::whereMonth('created_at', now()->subMonth()->month)->count();
        $trainerChange = $trainersThisMonth - $trainersLastMonth;

        return Inertia::render('Branches/Index', [
            'branches' => Branch::withCount(['students', 'trainers'])
                ->withCount(['lessons' => fn($q) => $q->whereMonth('start_time', now()->month)])
                ->orderBy('name')
                ->get()
                ->map(function ($branch) {
                    $branch->revenue = Payment::whereHas('student', fn($q) => $q->where('branch_id', $branch->id))
                        ->whereMonth('paid_at', now()->month)
                        ->sum('amount');
                    return $branch;
                }),
            'stats' => [
                ['title' => 'Branches', 'value' => Branch::count(), 'change' => Branch::where('status', 'active')->count() . ' active', 'icon' => 'pi pi-building', 'color' => 'purple', 'positive' => false],
                ['title' => 'Students', 'value' => Student::count(), 'change' => ($studentChange >= 0 ? '+' : '') . $studentChange . ' this month', 'icon' => 'pi pi-users', 'color' => 'blue', 'positive' => true],
                ['title' => 'Trainers', 'value' => Trainer::count(), 'change' => ($trainerChange >= 0 ? '+' : '') . $trainerChange . ' this month', 'icon' => 'pi pi-user', 'color' => 'green', 'positive' => true],
                ['title' => 'Total Capacity', 'value' => Branch::sum('capacity'), 'change' => 'Students limit', 'icon' => 'pi pi-chart-bar', 'color' => 'orange', 'positive' => false],
                ['title' => 'Occupancy Rate', 'value' => Branch::sum('capacity') > 0 ? round((Student::count() / Branch::sum('capacity')) * 100) . '%' : 'N/A', 'change' => 'Students / Capacity', 'icon' => 'pi pi-percentage', 'color' => 'yellow', 'positive' => false],
                ['title' => 'Revenue', 'value' => '$' . number_format(Payment::whereMonth('paid_at', now()->month)->sum('amount')), 'change' => 'This month', 'icon' => 'pi pi-wallet', 'color' => 'gold', 'positive' => false],
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Branches/Create');
    }

    public function show(Branch $branch)
    {
        $branch->loadCount(['students', 'trainers', 'lessons']);

        $revenue = Payment::whereHas('student', fn($q) => $q->where('branch_id', $branch->id))
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');

        $weekLessons = Lesson::where('branch_id', $branch->id)
            ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return Inertia::render('Branches/Show', [
            'branch' => $branch,
            'stats' => [
                ['title' => 'Students', 'value' => $branch->students_count, 'icon' => 'pi pi-users', 'color' => 'purple'],
                ['title' => 'Trainers', 'value' => $branch->trainers_count, 'icon' => 'pi pi-user', 'color' => 'blue'],
                ['title' => 'Week Lessons', 'value' => $weekLessons, 'icon' => 'pi pi-calendar', 'color' => 'green'],
                ['title' => 'Revenue', 'value' => '$' . number_format($revenue), 'icon' => 'pi pi-wallet', 'color' => 'gold'],
                ['title' => 'Capacity', 'value' => $branch->capacity ?: 'N/A', 'icon' => 'pi pi-chart-bar', 'color' => 'orange'],
                ['title' => 'Occupancy', 'value' => $branch->capacity > 0 ? round(($branch->students_count / $branch->capacity) * 100) . '%' : 'N/A', 'icon' => 'pi pi-percentage', 'color' => 'yellow'],
            ],
        ]);
    }

    public function edit(Branch $branch)
    {
        $branch->loadCount(['students', 'trainers', 'lessons']);

        return Inertia::render('Branches/Edit', [
            'branch' => $branch,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|in:main,additional,partner',
            'short_name' => 'nullable|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20|unique:branches,phone',
            'opening_date' => 'nullable|date',
            'code' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'postal_code' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'capacity' => 'nullable|integer|min:1',
            'area' => 'nullable|integer|min:1',
            'status' => 'nullable|in:active,inactive',
        ]);
        Branch::create($validated);

        return redirect()->route('branches.index')->with('success', 'Branch created.');
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|in:main,additional,partner',
            'short_name' => 'nullable|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20|unique:branches,phone,' . $branch->id,
            'opening_date' => 'nullable|date',
            'code' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'postal_code' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'capacity' => 'nullable|integer|min:1',
            'area' => 'nullable|integer|min:1',
            'status' => 'nullable|in:active,inactive',
        ]);
        $branch->update($validated);

        return redirect()->route('branches.index')->with('success', 'Branch updated.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return back()->with('success', 'Branch deleted');
    }
}
