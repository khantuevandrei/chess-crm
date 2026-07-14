<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import PaymentForm from './Components/PaymentForm.vue'

defineProps({ students: Array })
</script>

<template>
    <AuthenticatedLayout title="Add Payment">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/payments" class="text-gray-500 no-underline">Payments</Link>
                / New Payment
            </div>
            <h1 class="page-title">Create Payment</h1>
        </div>
        <PaymentForm :students="students" />
    </AuthenticatedLayout>
</template>
