<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    students: Array,
    branches: Array,
    trainers: Array,
    success: String
})

const form = useForm({
    first_name: '',
    last_name: '',
    birth_date: '',
    fide_rating: '',
    local_rating: '',
    rank: '',
    parent_name: '',
    parent_phone: '',
    branch_id: '',
    trainer_ids: []
})

const editingId = ref(null)
const editForm = useForm({
    first_name: '',
    last_name: '',
    birth_date: '',
    fide_rating: '',
    local_rating: '',
    rank: '',
    parent_name: '',
    parent_phone: '',
    branch_id: '',
    trainer_ids: []
})

function startEdit(student) {
    editingId.value = student.id
    editForm.first_name = student.first_name
    editForm.last_name = student.last_name
    editForm.birth_date = student.birth_date
    editForm.fide_rating = student.fide_rating
    editForm.local_rating = student.local_rating
    editForm.rank = student.rank
    editForm.parent_name = student.parent_name
    editForm.parent_phone = student.parent_phone
    editForm.branch_id = student.branch_id
    editForm.trainer_ids = student.trainer_ids.map(t => t.id)
}

function cancelEdit(id) {
    editingId.value = null
}

function updateStudent(id) {
    editForm.put(`/students/${id}`, {
        onSuccess: () => editingId.value = null
    })
}

function deleteStudent(id) {
    if (confirm('Delete student?')) {
        router.delete(`/students/${id}`)
    }
}
</script>

<template>
    <h1>Students</h1>

    <p v-if="$page.props.success" style="color:green">
        {{ $page.props.success }}
    </p>

    <form @submit.prevent="form.post('/students', {
        onSuccess: () => form.reset()
    })">
        <input v-model="form.first_name" placeholder="First name" />
        <p v-if="form.errors.first_name" style="color:red">{{ form.errors.first_name }}</p>

        <input v-model="form.last_name" placeholder="Last name" />
        <p v-if="form.errors.last_name" style="color:red">{{ form.errors.last_name }}</p>

        <input type="date" v-model="form.birth_date" placeholder="Birth date" />
        <p v-if="form.errors.birth_date" style="color:red">{{ form.errors.birth_date }}</p>

        <input v-model="form.fide_rating" placeholder="Fide rating" />
        <p v-if="form.errors.fide_rating" style="color:red">{{ form.errors.fide_rating }}</p>

        <input v-model="form.local_rating" placeholder="Local rating" />
        <p v-if="form.errors.local_rating" style="color:red">{{ form.errors.local_rating }}</p>

        <input v-model="form.rank" placeholder="Rank" />
        <p v-if="form.errors.rank" style="color:red">{{ form.errors.rank }}</p>

        <input v-model="form.parent_name" placeholder="Parent name" />
        <p v-if="form.errors.parent_name" style="color:red">{{ form.errors.parent_name }}</p>

        <input v-model="form.parent_phone" placeholder="Parent phone" />
        <p v-if="form.errors.parent_phone" style="color:red">{{ form.errors.parent_phone }}</p>

        <select v-model="form.branch_id">
            <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                {{ branch.name }}
            </option>
        </select>

        <select v-model="form.trainer_ids" multiple>
            <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                {{ trainer.last_name }} {{ trainer.first_name }}
            </option>
        </select>

        <button type="submit" :disabled="form.processing">Add</button>
    </form>

    <ul>
        <li v-for="student in students" :key="student.id">
            <template v-if="editingId === student.id">
                <input v-model="editForm.first_name">
                <p v-if="editForm.errors.first_name" style="color:red">{{ editForm.errors.first_name }}</p>

                <input v-model="editForm.last_name">
                <p v-if="editForm.errors.last_name" style="color:red">{{ editForm.errors.last_name }}</p>

                <input type="date" v-model="editForm.birth_date">
                <p v-if="editForm.errors.birth_date" style="color:red">{{ editForm.errors.birth_date }}</p>

                <input v-model="editForm.fide_rating">
                <p v-if="editForm.errors.fide_rating" style="color:red">{{ editForm.errors.fide_rating }}</p>

                <input v-model="editForm.local_rating">
                <p v-if="editForm.errors.local_rating" style="color:red">{{ editForm.errors.local_rating }}</p>

                <input v-model="editForm.rank">
                <p v-if="editForm.errors.rank" style="color:red">{{ editForm.errors.rank }}</p>

                <input v-model="editForm.parent_name">
                <p v-if="editForm.errors.parent_name" style="color:red">{{ editForm.errors.parent_name }}</p>

                <input v-model="editForm.parent_phone">
                <p v-if="editForm.errors.parent_phone" style="color:red">{{ editForm.errors.parent_phone }}</p>

                <select v-model="editForm.branch_id">
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                        {{ branch.name }}
                    </option>
                </select>

                <select v-model="editForm.trainer_ids" multiple>
                    <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                        {{ trainer.last_name }} {{ trainer.first_name }}
                    </option>
                </select>

                <button @click="updateStudent(student.id)">Save</button>
                <button @click="cancelEdit()">Cancel</button>
            </template>
            <template v-else>
                {{ student.first_name }} {{ student.last_name }}
                <button @click="startEdit(student)">Edit</button>
                <button @click="deleteStudent(student.id)">Delete</button>
            </template>
        </li>
    </ul>
</template>
