<script setup>
import { useForm } from '@inertiajs/vue3'
import { InputText, Button, Card } from 'primevue'

const props = defineProps({
    payment: { type: Object, default: null },
    students: { type: Array, required: true },
})

const isEdit = !!props.payment

const form = useForm({
    student_id: props.payment?.student_id || '',
    amount: props.payment?.amount || '',
    paid_at: props.payment?.paid_at || '',
    method: props.payment?.method || 'cash',
    status: props.payment?.status || 'paid',
    description: props.payment?.description || '',
})

function submit() {
    if (isEdit) {
        form.put(`/payments/${props.payment.id}`)
    } else {
        form.post('/payments')
    }
}

function goBack() {
    window.history.back()
}
</script>

<template>
    <form @submit.prevent="submit">
        <Card class="mb-4">
            <template #title>Payment Details</template>
            <template #content>
                <div class="grid">
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Student *</label>
                        <select v-model="form.student_id" class="w-full p-2 border-round">
                            <option value="">Select Student</option>
                            <option v-for="student in students" :key="student.id" :value="student.id">
                                {{ student.last_name }} {{ student.first_name }}
                            </option>
                        </select>
                        <p v-if="form.errors.student_id" class="mt-1 text-red-500 text-sm">{{ form.errors.student_id }}
                        </p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Amount *</label>
                        <InputText v-model="form.amount" type="number" step="0.01" placeholder="Amount"
                            class="w-full" />
                        <p v-if="form.errors.amount" class="mt-1 text-red-500 text-sm">{{ form.errors.amount }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Date *</label>
                        <InputText type="datetime-local" v-model="form.paid_at" class="w-full" />
                        <p v-if="form.errors.paid_at" class="mt-1 text-red-500 text-sm">{{ form.errors.paid_at }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Method *</label>
                        <select v-model="form.method" class="w-full p-2 border-round">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select v-model="form.status" class="w-full p-2 border-round">
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Description</label>
                        <InputText v-model="form.description" placeholder="Description" class="w-full" />
                        <p v-if="form.errors.description" class="mt-1 text-red-500 text-sm">{{ form.errors.description
                            }}</p>
                    </div>
                </div>
            </template>
        </Card>

        <div class="flex justify-content-between">
            <button type="button" @click="goBack" class="p-button p-button-secondary no-underline">← Back</button>
            <Button type="submit" :disabled="form.processing">
                {{ isEdit ? 'Save Changes' : 'Create Payment' }}
            </Button>
        </div>
    </form>
</template>
