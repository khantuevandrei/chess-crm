<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    payments: Array,
    students: Array
})

const form = useForm({
    student_id: '',
    amount: '',
    paid_at: '',
    method: '',
    description: ''
})

const editingId = ref(null)
const editForm = useForm({
    student_id: '',
    amount: '',
    paid_at: '',
    method: '',
    description: ''
})

function startEdit(payment) {
    editingId.value = payment.id
    editForm.student_id = payment.student_id
    editForm.amount = payment.amount
    editForm.paid_at = payment.paid_at
    editForm.method = payment.method
    editForm.description = payment.description
}

function cancelEdit(id) {
    editingId.value = null
}

function updatePayment(id) {
    editForm.put(`/payments/${id}`, {
        onSuccess: () => editingId.value = null
    })
}

function deletePayment(id) {
    if (confirm('Delete payment?')) {
        router.delete(`/payments/${id}`)
    }
}
</script>

<template>
    <h1>Payments</h1>

    <p v-if="$page.props.success" style="color: green;">
        {{ $page.props.success }}
    </p>

    <form @submit.prevent="form.post(`/payments`, {
        onSuccess: () => form.reset()
    })">
        <select v-model="form.student_id">
            <option v-for="student in students" :key="student.id" :value="student.id">
                {{ student.last_name }} {{ student.first_name }}
            </option>
        </select>

        <input v-model="form.amount" placeholder="Amount" />
        <p v-if="form.errors.amount" style="color:red">{{ form.errors.amount }}</p>

        <input type="datetime-local" v-model="form.paid_at" placeholder="Paid at" />
        <p v-if="form.errors.paid_at" style="color:red">{{ form.errors.paid_at }}</p>

        <select v-model="form.method">
            <option>cash</option>
            <option>card</option>
            <option>transfer</option>
        </select>

        <input v-model="form.description" placeholder="Description" />
        <p v-if="form.errors.description" style="color:red">{{ form.errors.description }}</p>

        <button type="submit" :disabled="form.processing">Add</button>
    </form>

    <ul>
        <li v-for="payment in payments" :key="payment.id">
            <template v-if="editingId === payment.id">
                <select v-model="editForm.student_id">
                    <option v-for="student in students" :key="student.id" :value="student.id">
                        {{ student.last_name }} {{ student.first_name }}
                    </option>
                </select>

                <input v-model="editForm.amount" placeholder="Amount" />
                <p v-if="editForm.errors.amount" style="color:red">{{ editForm.errors.amount }}</p>

                <input type="datetime-local" v-model="editForm.paid_at" placeholder="Paid at" />
                <p v-if="editForm.errors.paid_at" style="color:red">{{ editForm.errors.paid_at }}</p>

                <select v-model="editForm.method">
                    <option>cash</option>
                    <option>card</option>
                    <option>transfer</option>
                </select>

                <input v-model="editForm.description" placeholder="Description" />
                <p v-if="editForm.errors.description" style="color:red">{{ editForm.errors.description }}</p>

                <button @click="updatePayment(payment.id)">Save</button>
                <button @click="cancelEdit()">Cancel</button>
            </template>
            <template v-else>
                {{ payment.id }} - {{ payment.student.last_name }} {{ payment.student.first_name }} - {{ payment.amount
                }} {{
                    payment.paid_at }}
                <button @click="startEdit(payment)">Edit</button>
                <button @click="deletePayment(payment.id)">Delete</button>
            </template>
        </li>
    </ul>
</template>
