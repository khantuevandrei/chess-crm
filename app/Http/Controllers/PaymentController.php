<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        $now = now();
        $monthRevenue = Payment::whereMonth('paid_at', $now->month)->sum('amount');
        $lastMonthRevenue = Payment::whereMonth('paid_at', $now->subMonth()->month)->sum('amount');
        $revenueChange = $lastMonthRevenue > 0 ? round((($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100) : 0;
        $todayRevenue = Payment::whereDate('paid_at', today())->sum('amount');
        $pending = Payment::where('status', 'pending')->count();
        $overdue = Payment::where('status', 'overdue')->count();

        $payingStudents = Payment::whereMonth('paid_at', $now->month)->distinct('student_id')->count();
        $avgCheck = $payingStudents > 0 ? $monthRevenue / $payingStudents : 0;

        return Inertia::render('Payments/Index', [
            'payments' => Payment::with('student')->orderBy('paid_at', 'desc')->get(),
            'students' => Student::orderBy('last_name')->get(),
            'stats' => [
                ['title' => 'Monthly Revenue', 'value' => '$'.number_format($monthRevenue), 'change' => ($revenueChange >= 0 ? '+' : '').$revenueChange.'% vs last month', 'icon' => 'pi pi-wallet', 'color' => 'purple', 'positive' => $revenueChange >= 0],
                ['title' => 'Today', 'value' => '$'.number_format($todayRevenue), 'change' => 'Received today', 'icon' => 'pi pi-calendar', 'color' => 'blue', 'positive' => false],
                ['title' => 'Pending', 'value' => $pending, 'change' => 'Awaiting payment', 'icon' => 'pi pi-clock', 'color' => 'orange', 'positive' => false],
                ['title' => 'Overdue', 'value' => $overdue, 'change' => 'Requires attention', 'icon' => 'pi pi-exclamation-triangle', 'color' => 'red', 'positive' => false],
                ['title' => 'Ending Soon', 'value' => '24', 'change' => 'Within 7 days', 'icon' => 'pi pi-hourglass', 'color' => 'yellow', 'positive' => false],
                ['title' => 'Avg Check', 'value' => '$'.number_format($avgCheck, 2), 'change' => 'Per paying student', 'icon' => 'pi pi-chart-bar', 'color' => 'green', 'positive' => false],
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Payments/Create', [
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function edit(Payment $payment)
    {
        return Inertia::render('Payments/Edit', [
            'payment' => $payment->load('student'),
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function show(Payment $payment)
    {
        return Inertia::render('Payments/Show', [
            'payment' => $payment->load('student'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'method' => 'required|string|max:20|in:cash,card,transfer',
            'description' => 'nullable|string|max:500',
            'status' => 'nullable|in:paid,pending,overdue',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Payment created.');
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'method' => 'required|string|max:20|in:cash,card,transfer',
            'description' => 'nullable|string|max:500',
            'status' => 'nullable|in:paid,pending,overdue',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Payment updated.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return back()->with('success', 'Payment deleted.');
    }
}
