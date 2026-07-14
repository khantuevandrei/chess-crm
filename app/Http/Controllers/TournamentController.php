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
        $now = now();
        $upcoming = Tournament::where('start_date', '>=', today())->count();
        $completed = Tournament::where('status', 'completed')->count();
        $total = Tournament::count();
        $thisYear = Tournament::whereYear('start_date', $now->year)->count();

        return Inertia::render('Tournaments/Index', [
            'tournaments' => Tournament::withCount('tournamentResults')
                ->orderBy('start_date', 'desc')->get(),
            'stats' => [
                ['title' => 'Total', 'value' => $total, 'change' => $thisYear.' this year', 'icon' => 'pi pi-trophy', 'color' => 'purple', 'positive' => false],
                ['title' => 'Upcoming', 'value' => $upcoming, 'change' => 'Scheduled', 'icon' => 'pi pi-calendar', 'color' => 'blue', 'positive' => false],
                ['title' => 'Completed', 'value' => $completed, 'change' => round(($completed / max($total, 1)) * 100).'% of total', 'icon' => 'pi pi-check-circle', 'color' => 'green', 'positive' => false],
                ['title' => 'Participants', 'value' => TournamentResult::count(), 'change' => 'Total results', 'icon' => 'pi pi-users', 'color' => 'orange', 'positive' => false],
                ['title' => 'Avg Participants', 'value' => $total > 0 ? round(TournamentResult::count() / $total) : 'N/A', 'change' => 'Per tournament', 'icon' => 'pi pi-chart-bar', 'color' => 'yellow', 'positive' => false],
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Tournaments/Create');
    }

    public function edit(Tournament $tournament)
    {
        return Inertia::render('Tournaments/Edit', [
            'tournament' => $tournament,
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
            'status' => 'nullable|in:upcoming,active,completed,cancelled',
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
            'status' => 'nullable|in:upcoming,active,completed,cancelled',
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
