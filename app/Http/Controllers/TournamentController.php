<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Tournament;
use App\Models\TournamentResult;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TournamentController extends Controller
{
    public function index()
    {
        return Inertia::render('Tournaments/Index', [
            'tournaments' => Tournament::orderBy('start_date', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|string|max:20',
        ]);

        Tournament::create($validated);

        return redirect()->route('tournaments.index')->with('success', 'Tournament created.');
    }

    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|string|max:20',
        ]);

        $tournament->update($validated);

        return redirect()->route('tournaments.index')->with('success', 'Tournament updated.');
    }

    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return back()->with('success', 'Tournament deleted');
    }

    public function show(Tournament $tournament)
    {
        return Inertia::render('Tournaments/Show', [
            'tournament' => $tournament->load('tournamentResults.student'),
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function addResult(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'place' => 'required|integer|min:1',
            'points' => 'required|numeric|min:0',
            'rating_change' => 'nullable|integer',
        ]);

        $tournament->tournamentResults()->create($validated);

        return back()->with('success', 'Result added.');
    }

    public function deleteResult(Tournament $tournament, TournamentResult $result)
    {
        $result->delete();

        return back()->with('success', 'Result deleted.');
    }
}
