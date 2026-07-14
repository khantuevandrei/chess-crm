<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { Card, Button, Tag } from 'primevue'

defineProps({ payment: Object })

function deletePayment(id) {
    if (confirm('Delete this payment?')) {
        router.delete(`/payments/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Payment Details">
        <div class="flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-sm text-gray-500 mb-1">
                    <Link href="/payments" class="text-gray-500 no-underline">Payments</Link>
                    / #{{ payment.id }}
                </div>
                <div class="flex align-items-center gap-2">
                    <h1 class="page-title">${{ payment.amount }}</h1>
                    <Tag :value="payment.status"
                        :severity="payment.status === 'paid' ? 'success' : payment.status === 'pending' ? 'warning' : 'danger'" />
                </div>
            </div>
            <div class="flex gap-2">
                <Link href="/payments" class="p-button p-button-secondary no-underline">Back</Link>
            </div>
        </div>

        <div class="grid">
            <div class="col-12 md:col-8">
                <Card>
                    <template #title>Payment Information</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6"><strong>Student:</strong> {{ payment.student?.last_name }} {{
                                payment.student?.first_name }}</div>
                            <div class="col-6"><strong>Amount:</strong> ${{ payment.amount }}</div>
                            <div class="col-6"><strong>Method:</strong> {{ payment.method }}</div>
                            <div class="col-6"><strong>Date:</strong> {{ payment.paid_at }}</div>
                            <div class="col-6"><strong>Status:</strong> {{ payment.status }}</div>
                            <div class="col-12" v-if="payment.description"><strong>Description:</strong> {{
                                payment.description }}</div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-4">
                <Card class="border-red-200" style="border: 1px solid #fecaca; background: #fef2f2;">
                    <template #title><span style="color: #dc2626;">Danger Zone</span></template>
                    <template #content>
                        <p class="text-sm text-gray-600 mb-3">Deleting a payment is irreversible.</p>
                        <Button severity="danger" @click="deletePayment(payment.id)" class="w-full">Delete
                            Payment</Button>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
