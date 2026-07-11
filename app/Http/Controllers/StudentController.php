<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Student;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index', [
            'students' => Student::with('branch')->orderBy('last_name')->get(),
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
            'parent_name' => 'required|string|max:20',
            'parent_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $student = Student::create($validated);

        if ($request->has('trainer_ids')) {
            $student->trainers()->sync($request->trainer_ids);
        }

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
            'parent_name' => 'required|string|max:20',
            'parent_phone' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $student->update($validated);
        $student->trainers()->sync($request->trainer_ids ?? []);

        return redirect()->route('students.index')->with('success', 'Student updated');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('success', 'Student deleted');
    }
}
