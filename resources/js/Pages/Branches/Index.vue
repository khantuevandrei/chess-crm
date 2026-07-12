<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { InputText, Button, Card } from 'primevue';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    branches: Array,
    success: String,
})

const showForm = ref(false)
const form = useForm({ name: '', address: '', phone: '' })
const editingId = ref(null)
const editForm = useForm({ name: '', address: '', phone: '' })

function openAddForm() {
    showForm.value = true
    form.reset()
}

function storeBranch() {
    form.post('/branches', { onSuccess: () => { showForm.value = false; form.reset() } })
}

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
    editForm.put(`/branches/${id}`, { onSuccess: () => editingId.value = null })
}

function deleteBranch(id) {
    if (confirm('Delete branch?')) {
        router.delete(`/branches/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Branches">

        <p v-if="$page.props.success" style="color:green" class="mb-3">{{ $page.props.success }}</p>

        <div class="flex justify-content-between align-items-center mb-4">
            <span class="text-xl font-bold">{{ branches.length }} Branches</span>
            <Button @click="openAddForm" icon="pi pi-plus" label="Add Branch" />
        </div>

        <!-- Creation form -->
        <Card v-if="showForm" class="mb-4">
            <template #content>
                <form @submit.prevent="storeBranch">
                    <div class="flex flex-column gap-3">
                        <div>
                            <label class="text-sm text-gray-600 mb-1 block">Name</label>
                            <InputText v-model="form.name" placeholder="Enter branch name" class="w-full" />
                            <p v-if="form.errors.name" style="color:red" class="mt-1">{{ form.errors.name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 mb-1 block">Address</label>
                            <InputText v-model="form.address" placeholder="Enter address" class="w-full" />
                            <p v-if="form.errors.address" style="color:red" class="mt-1">{{ form.errors.address }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 mb-1 block">Phone</label>
                            <InputText v-model="form.phone" placeholder="Enter phone" class="w-full" />
                            <p v-if="form.errors.phone" style="color:red" class="mt-1">{{ form.errors.phone }}</p>
                        </div>
                        <div class="flex gap-2">
                            <Button type="submit" :disabled="form.processing">Save</Button>
                            <Button severity="secondary" @click="showForm = false">Cancel</Button>
                        </div>
                    </div>
                </form>
            </template>
        </Card>

        <!-- List -->
        <div class="flex flex-column gap-3">
            <Card v-for="branch in branches" :key="branch.id">
                <template #content>
                    <template v-if="editingId === branch.id">
                        <div class="flex flex-column gap-3">
                            <InputText v-model="editForm.name" class="w-full" />
                            <InputText v-model="editForm.address" class="w-full" />
                            <InputText v-model="editForm.phone" class="w-full" />
                            <div class="flex gap-2">
                                <Button @click="updateBranch(branch.id)">Save</Button>
                                <Button severity="secondary" @click="cancelEdit()">Cancel</Button>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="flex justify-content-between align-items-center">
                            <div>
                                <div class="font-bold text-lg">{{ branch.name }}</div>
                                <div class="text-gray-500">{{ branch.address }}</div>
                                <div class="text-gray-500">{{ branch.phone }}</div>
                            </div>
                            <div class="flex gap-2">
                                <Button severity="secondary" @click="startEdit(branch)">Edit</Button>
                                <Button severity="danger" @click="deleteBranch(branch.id)">Delete</Button>
                            </div>
                        </div>
                    </template>
                </template>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
