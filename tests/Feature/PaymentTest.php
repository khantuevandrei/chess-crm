<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_payments_index(): void
    {
        $user = User::factory()->create();
        Payment::factory()->create(['amount' => 100]);

        $response = $this->actingAs($user)->get('/payments');

        $response->assertStatus(200);
        $response->assertSee('100');
    }

    public function test_payment_creation_requires_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/payments', [
            'student_id' => '',
            'amount' => '',
            'paid_at' => '',
            'method' => '',
        ]);

        $response->assertSessionHasErrors(['student_id', 'amount', 'paid_at', 'method']);
    }
}
