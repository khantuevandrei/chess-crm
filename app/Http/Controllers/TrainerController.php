<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainerController extends Controller
{
    public function index()
    {
        return Inertia::render('Trainers/Index', [
            'trainers' => Trainer::with('branch')->orderBy('last_name')->get(),
            'branches' => Branch::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|unique:trainers,email',
            'phone' => 'required|string|max:20|unique:trainers,phone',
            'specialization' => 'required|string|max:20',
            'rating' => 'nullable|integer',
            'branch_id' => 'required|exists:branches,id',
            'bio' => 'nullable|string|max:500'
        ]);

        Trainer::create($validated);

        return redirect()->route('trainers.index')->with('success', 'Trainer created.');
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|unique:trainers,email,' . $trainer->id,
            'phone' => 'required|string|max:20|unique:trainers,phone,' . $trainer->id,
            'specialization' => 'required|string|max:20',
            'rating' => 'nullable|integer',
            'branch_id' => 'nullable|exists:branches,id',
            'bio' => 'nullable|string|max:500'
        ]);

        $trainer->update($validated);

        return redirect()->route('trainers.index')->with('success', 'Trainer created');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return back()->with('success', 'Trainer deleted.');
    }
}
