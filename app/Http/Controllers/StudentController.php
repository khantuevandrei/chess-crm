<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        $thisMonth = [now()->startOfMonth(), now()->endOfMonth()];
        $lastMonth = [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()];

        $studentsThisMonth = Student::whereBetween('created_at', $thisMonth)->count();
        $studentsLastMonth = Student::whereBetween('created_at', $lastMonth)->count();
        $studentChange = $studentsThisMonth - $studentsLastMonth;

        $paidThisMonth = Payment::whereBetween('paid_at', $thisMonth)->sum('amount');
        $paidLastMonth = Payment::whereBetween('paid_at', $lastMonth)->sum('amount');
        $paidChange = $paidLastMonth > 0 ? round((($paidThisMonth - $paidLastMonth) / $paidLastMonth) * 100) : 0;

        $averageCheck = Student::count() > 0 ? $paidThisMonth / Student::count() : 0;

        return Inertia::render('Students/Index', [
            'students' => Student::with(['branch', 'trainers'])
                ->orderBy('last_name')->get(),
            'branches' => Branch::orderBy('name')->get(),
            'trainers' => Trainer::orderBy('last_name')->get(),
            'stats' => [
                ['title' => 'Total Students', 'value' => Student::count(), 'change' => ($studentChange >= 0 ? '+' : '') . $studentChange . ' this month', 'icon' => 'pi pi-users', 'color' => 'purple', 'positive' => true],
                ['title' => 'Active', 'value' => Student::where('status', 'active')->count(), 'change' => round((Student::where('status', 'active')->count() / max(Student::count(), 1)) * 100) . '% of total', 'icon' => 'pi pi-check-circle', 'color' => 'green', 'positive' => false],
                ['title' => 'New This Month', 'value' => $studentsThisMonth, 'change' => '+' . $studentsLastMonth . ' last month', 'icon' => 'pi pi-plus-circle', 'color' => 'blue', 'positive' => true],
                ['title' => 'Active Groups', 'value' => 'N/A', 'change' => 'Groups feature coming soon', 'icon' => 'pi pi-users', 'color' => 'orange', 'positive' => false],
                ['title' => 'Average Check', 'value' => '$' . number_format($averageCheck, 2), 'change' => 'Per student this month', 'icon' => 'pi pi-wallet', 'color' => 'gold', 'positive' => false],
                ['title' => 'Paid This Month', 'value' => '$' . number_format($paidThisMonth), 'change' => ($paidChange >= 0 ? '+' : '') . $paidChange . '% vs last month', 'icon' => 'pi pi-wallet', 'color' => 'gold', 'positive' => true],
            ],
        ]);
    }
    public function show(Student $student)
    {
        $student->load(['branch', 'trainers', 'payments']);

        return Inertia::render('Students/Show', [
            'student' => $student,
        ]);
    }

    public function create()
    {
        return Inertia::render('Students/Create', [
            'branches' => Branch::orderBy('name')->get(),
            'trainers' => Trainer::orderBy('last_name')->get(),
        ]);
    }

    public function edit(Student $student)
    {
        $student->load('trainers');

        return Inertia::render('Students/Edit', [
            'student' => $student,
            'branches' => Branch::orderBy('name')->get(),
            'trainers' => Trainer::orderBy('last_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'fide_rating' => 'nullable|integer',
            'local_rating' => 'nullable|integer',
            'rank' => 'string|max:20|nullable',
            'parent_name' => 'required|string|max:100',
            'parent_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'status' => 'nullable|in:active,inactive',
            'trainer_ids' => 'nullable|array',
            'trainer_ids.*' => 'integer|exists:trainers,id',
        ]);

        $student = Student::create($validated);
        $student->trainers()->sync($validated['trainer_ids'] ?? []);

        return redirect()->route('students.index')->with('success', 'Student created');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'fide_rating' => 'nullable|integer',
            'local_rating' => 'nullable|integer',
            'rank' => 'string|max:20|nullable',
            'parent_name' => 'required|string|max:100',
            'parent_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'status' => 'nullable|in:active,inactive',
            'trainer_ids' => 'nullable|array',
            'trainer_ids.*' => 'integer|exists:trainers,id',
        ]);

        $student->update($validated);
        $student->trainers()->sync($validated['trainer_ids'] ?? []);

        return redirect()->route('students.index')->with('success', 'Student updated');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('success', 'Student deleted');
    }
}
