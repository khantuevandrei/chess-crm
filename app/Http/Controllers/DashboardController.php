<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Tournament;
use App\Models\Trainer;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $thisMonth = [now()->startOfMonth(), now()->endOfMonth()];
        $lastMonth = [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()];

        $studentsThisMonth = Student::whereBetween('created_at', $thisMonth)->count();
        $studentsLastMonth = Student::whereBetween('created_at', $lastMonth)->count();
        $studentChange = $studentsThisMonth - $studentsLastMonth;

        $trainersThisMonth = Trainer::whereBetween('created_at', $thisMonth)->count();
        $trainersLastMonth = Trainer::whereBetween('created_at', $lastMonth)->count();
        $trainerChange = $trainersThisMonth - $trainersLastMonth;

        $revenueThisMonth = Payment::whereBetween('paid_at', $thisMonth)->sum('amount');
        $revenueLastMonth = Payment::whereBetween('paid_at', $lastMonth)->sum('amount');
        $revenueChange = $revenueLastMonth > 0 ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100) : 0;
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                ['title' => 'Branches', 'value' => Branch::count(), 'change' => Branch::where('status', 'active')->count() . ' active', 'icon' => 'pi pi-building', 'color' => 'purple', 'positive' => false],
                ['title' => 'Trainers', 'value' => Trainer::count(), 'change' => ($trainerChange >= 0 ? '+' : '') . $trainerChange . ' this month', 'icon' => 'pi pi-user', 'color' => 'blue', 'positive' => true],
                ['title' => 'Students', 'value' => Student::count(), 'change' => ($studentChange >= 0 ? '+' : '') . $studentChange . ' this month', 'icon' => 'pi pi-users', 'color' => 'green', 'positive' => true],
                ['title' => 'Week Lessons', 'value' => Lesson::whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])->count(), 'change' => 'Lessons', 'icon' => 'pi pi-calendar', 'color' => 'orange', 'positive' => false],
                ['title' => 'Today Lessons', 'value' => Lesson::whereDate('start_time', today())->count(), 'change' => 'Scheduled', 'icon' => 'pi pi-calendar-clock', 'color' => 'yellow', 'positive' => false],
                ['title' => 'Revenue', 'value' => '$' . number_format($revenueThisMonth), 'change' => ($revenueChange >= 0 ? '+' : '') . $revenueChange . '%', 'icon' => 'pi pi-wallet', 'color' => 'gold', 'positive' => true],
            ],
            'tournaments' => Tournament::where('start_date', '>=', today())
                ->orderBy('start_date')
                ->limit(4)
                ->get()
                ->map(fn($t) => [
                    'id' => $t->id,
                    'name' => $t->name,
                    'date' => $t->start_date->format('d M Y'),
                    'location' => $t->location,
                    'type' => $t->type,
                    'icon' => 'pi pi-trophy',
                    'color' => 'purple',
                ]),
            'revenueData' => Payment::selectRaw("DATE_TRUNC('day', paid_at) as date, SUM(amount) as total")
                ->whereBetween('paid_at', $thisMonth)
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->map(fn($p) => [
                    'date' => Carbon::parse($p->date)->format('d M'),
                    'amount' => $p->total,
                ]),
        ]);
    }
}
