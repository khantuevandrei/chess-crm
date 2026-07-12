<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { InputText, Button } from 'primevue';

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
        <div class="flex flex-column gap-2 mb-3 max-w-sm">
            <InputText v-model="form.name" placeholder="Title" />
            <p v-if="form.errors.name" style="color:red">{{ form.errors.name }}</p>

            <InputText v-model="form.address" placeholder="Address" />
            <p v-if="form.errors.address" style="color:red">{{ form.errors.address }}</p>

            <InputText v-model="form.phone" placeholder="Phone" />
            <p v-if="form.errors.phone" style="color:red">{{ form.errors.phone }}</p>

            <Button type="submit" :disabled="form.processing">Add</Button>
        </div>
    </form>

    <ul class="flex flex-column gap-3">
        <li v-for="branch in branches" :key="branch.id">
            <template v-if="editingId === branch.id">
                <div class="flex flex-column gap-2">
                    <InputText v-model="editForm.name" />
                    <InputText v-model="editForm.address" />
                    <InputText v-model="editForm.phone" />
                    <div class="flex gap-2">
                        <Button @click="updateBranch(branch.id)">Save</Button>
                        <Button @click="cancelEdit()">Cancel</Button>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="flex gap-2 align-items-center">
                    <span>{{ branch.name }} - {{ branch.address }} - {{ branch.phone }}</span>
                    <Button @click="startEdit(branch)">Edit</Button>
                    <Button @click="deleteBranch(branch.id)">Delete</Button>
                </div>
            </template>
        </li>
    </ul>
</template>
