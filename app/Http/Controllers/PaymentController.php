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
        return Inertia::render('Payments/Index', [
            'payments' => Payment::with('student')->orderBy('paid_at', 'desc')->get(),
            'students' => Student::orderBy('last_name')->get(),
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
