<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    trainers: Array,
    branches: Array,
    success: String,
})

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    specialization: '',
    rating: '',
    branch_id: '',
    bio: ''
})

const editingId = ref(null)
const editForm = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    specialization: '',
    rating: '',
    branch_id: '',
    bio: ''
})

function startEdit(trainer) {
    editingId.value = trainer.id
    editForm.first_name = trainer.first_name
    editForm.last_name = trainer.last_name
    editForm.email = trainer.email
    editForm.phone = trainer.phone
    editForm.specialization = trainer.specialization
    editForm.rating = trainer.rating
    editForm.branch_id = trainer.branch_id
    editForm.bio = trainer.bio
}

function cancelEdit(id) {
    editingId.value = null
}

function updateTrainer(id) {
    editForm.put(`/trainers/${id}`, {
        onSuccess: () => editingId.value = null
    })
}

function deleteTrainer(id) {
    if (confirm('Delete trainer?')) {
        router.delete(`/trainers/${id}`)
    }
}
</script>

<template>
    <h1>Trainers</h1>

    <p v-if="$page.props.success" style="color:green">
        {{ $page.props.success }}
    </p>

    <form @submit.prevent="form.post('/trainers', {
        onSuccess: () => form.reset()
    })">
        <input v-model="form.first_name" placeholder="First name" />
        <p v-if="form.errors.first_name" style="color:red">{{ form.errors.first_name }}</p>

        <input v-model="form.last_name" placeholder="Last name" />
        <p v-if="form.errors.last_name" style="color:red">{{ form.errors.last_name }}</p>

        <input v-model="form.email" placeholder="Email" />
        <p v-if="form.errors.email" style="color:red">{{ form.errors.email }}</p>

        <input v-model="form.phone" placeholder="Phone" />
        <p v-if="form.errors.phone" style="color:red">{{ form.errors.phone }}</p>

        <input v-model="form.specialization" placeholder="Specialization" />
        <p v-if="form.errors.specialization" style="color:red">{{ form.errors.specialization }}</p>

        <input v-model="form.rating" placeholder="Rating" />
        <p v-if="form.errors.rating" style="color:red">{{ form.errors.rating }}</p>

        <select v-model="form.branch_id">
            <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                {{ branch.name }}
            </option>
        </select>

        <input v-model="form.bio" placeholder="Bio" />
        <p v-if="form.errors.bio" style="color:red">{{ form.errors.bio }}</p>

        <button type="submit" :disabled="form.processing">Add</button>
    </form>

    <ul>
        <li v-for="trainer in trainers" :key="trainer.id">
            <template v-if="editingId === trainer.id">
                <input v-model="editForm.first_name" />
                <p v-if="editForm.errors.first_name" style="color:red">{{ editForm.errors.first_name }}</p>

                <input v-model="editForm.last_name" />
                <p v-if="editForm.errors.last_name" style="color:red">{{ editForm.errors.last_name }}</p>

                <input v-model="editForm.email" />
                <p v-if="editForm.errors.email" style="color:red">{{ editForm.errors.email }}</p>

                <input v-model="editForm.phone" />
                <p v-if="editForm.errors.phone" style="color:red">{{ editForm.errors.phone }}</p>

                <input v-model="editForm.specialization" />
                <p v-if="editForm.errors.specialization" style="color:red">{{ editForm.errors.specialization }}</p>

                <input v-model="editForm.rating" />
                <p v-if="editForm.errors.rating" style="color:red">{{ editForm.errors.rating }}</p>

                <select v-model="editForm.branch_id">
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                        {{ branch.name }}
                    </option>
                </select>

                <input v-model="editForm.bio" />
                <p v-if="editForm.errors.bio" style="color:red">{{ editForm.errors.bio }}</p>

                <button @click="updateTrainer(trainer.id)">Save</button>
                <button @click="cancelEdit()">Cancel</button>
            </template>
            <template v-else>
                {{ trainer.first_name }} {{ trainer.last_name }}
                <button @click="startEdit(trainer)">Edit</button>
                <button @click="deleteTrainer(trainer.id)">Delete</button>
            </template>
        </li>
    </ul>
</template>
