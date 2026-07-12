<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Tournament;
use App\Models\Trainer;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $studentsThisMonth = Student::whereMonth('created_at', now()->month)->count();
        $studentsLastMonth = Student::whereMonth('created_at', now()->subMonth()->month)->count();
        $studentChange = $studentsThisMonth - $studentsLastMonth;

        $trainersThisMonth = Trainer::whereMonth('created_at', now()->month)->count();
        $trainersLastMonth = Trainer::whereMonth('created_at', now()->subMonth()->month)->count();
        $trainerChange = $trainersThisMonth - $trainersLastMonth;

        $revenueThisMonth = Payment::whereMonth('paid_at', now()->month)->sum('amount');
        $revenueLastMonth = Payment::whereMonth('paid_at', now()->subMonth()->month)->sum('amount');
        $revenueChange = $revenueLastMonth > 0 ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100) : 0;

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                ['title' => 'Branches', 'value' => Branch::count(), 'change' => Branch::where('status', 'active')->count() . ' active', 'icon' => 'pi pi-building', 'color' => 'purple', 'positive' => false],
                ['title' => 'Trainers', 'value' => Trainer::count(), 'change' => ($trainerChange >= 0 ? '+' : '') . $trainerChange . ' this month', 'icon' => 'pi pi-user', 'color' => 'blue', 'positive' => true],
                ['title' => 'Students', 'value' => Student::count(), 'change' => ($studentChange >= 0 ? '+' : '') . $studentChange . ' this month', 'icon' => 'pi pi-users', 'color' => 'green', 'positive' => true],
                ['title' => 'Week Lessons', 'value' => Lesson::whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])->count(), 'change' => 'Lessons', 'icon' => 'pi pi-calendar', 'color' => 'orange', 'positive' => false],
                ['title' => 'Today Lessons', 'value' => Lesson::whereDate('start_time', today())->count(), 'change' => 'Scheduled', 'icon' => 'pi pi-calendar-clock', 'color' => 'yellow', 'positive' => false],
                ['title' => 'Revenue', 'value' => '$' . number_format(Payment::whereMonth('paid_at', now()->month)->sum('amount')), 'change' => ($revenueChange >= 0 ? '+' : '') . $revenueChange . '%', 'icon' => 'pi pi-wallet', 'color' => 'gold', 'positive' => true],
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
        ]);
    }
}
