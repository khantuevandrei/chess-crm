<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    branches: Array,
    success: String,
})

const form = useForm({
    name: '',
    address: '',
    phone: ''
})

const editingId = ref(null)
const editForm = useForm({
    name: '',
    address: '',
    phone: ''
})

function startEdit(branch) {
    editingId.value = branch.id
    editForm.name = branch.name
    editForm.address = branch.address
    editForm.phone = branch.phone
}

function cancelEdit() {
    editingId.value = null
}

function updateBranch(id) {
    editForm.put(`/branches/${id}`, {
        onSuccess: () => editingId.value = null
    })
}

function deleteBranch(id) {
    if (confirm('Delete branch?')) {
        router.delete(`/branches/${id}`)
    }
}
</script>

<template>
    <h1>Branches</h1>

    <p v-if="$page.props.success" style="color:green">
        {{ $page.props.success }}
    </p>

    <form @submit.prevent="form.post('/branches', {
        onSuccess: () => form.reset()
    })">
        <input v-model="form.name" placeholder="Title" />
        <p v-if="form.errors.name" style="color:red">{{ form.errors.name }}</p>
        <input v-model="form.address" placeholder="Address" />
        <p v-if="form.errors.address" style="color:red">{{ form.errors.address }}</p>
        <input v-model="form.phone" placeholder="Phone" />
        <p v-if="form.errors.phone" style="color:red">{{ form.errors.phone }}</p>
        <button type="submit" :disabled="form.processing">Add</button>
    </form>

    <ul>
        <li v-for="branch in branches" :key="branch.id">
            <template v-if="editingId === branch.id">
                <input v-model="editForm.name" />
                <p v-if="editForm.errors.name" style="color:red">{{ editForm.errors.name }}</p>
                <input v-model="editForm.address" />
                <p v-if="editForm.errors.address" style="color:red">{{ editForm.errors.address }}</p>
                <input v-model="editForm.phone" />
                <p v-if="editForm.errors.phone" style="color:red">{{ editForm.errors.phone }}</p>
                <button @click="updateBranch(branch.id)">Save</button>
                <button @click="cancelEdit()">Cancel</button>
            </template>
            <template v-else>
                {{ branch.name }} - {{ branch.address }} - {{ branch.phone }}
                <button @click="startEdit(branch)">Edit</button>
                <button @click="deleteBranch(branch.id)">Delete</button>
            </template>
        </li>
    </ul>
</template>
