<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import PaymentForm from './Components/PaymentForm.vue'

defineProps({ payment: Object, students: Array })
</script>

<template>
    <AuthenticatedLayout title="Edit Payment">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/payments" class="text-gray-500 no-underline">Payments</Link>
                / {{ payment.student?.last_name }}
            </div>
            <h1 class="page-title">Edit Payment</h1>
        </div>
        <PaymentForm :payment="payment" :students="students" />
    </AuthenticatedLayout>
</template>
