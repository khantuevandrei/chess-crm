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
        return Inertia::render('Dashboard', [
            'stats' => [
                'students_count' => Student::count(),
                'trainers_count' => Trainer::count(),
                'branches_count' => Branch::count(),
                'today_lessons' => Lesson::whereDate('start_time', today())->count(),
                'week_lessons' => Lesson::whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'month_payments' => Payment::whereMonth('paid_at', now()->month)->sum('amount'),
                'upcoming_tournaments' => Tournament::where('start_date', '>=', today())->orderBy('start_date')->limit(3)->get(),
            ],
        ]);
    }
}
