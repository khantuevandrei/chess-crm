<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    lessons: Array,
    trainers: Array,
    students: Array,
    branches: Array
})

const form = useForm({
    trainer_id: '',
    student_id: '',
    branch_id: '',
    type: '',
    title: '',
    start_time: '',
    end_time: '',
    status: '',
    notes: ''
})

const editingId = ref(null)
const editForm = useForm({
    trainer_id: '',
    student_id: '',
    branch_id: '',
    type: '',
    title: '',
    start_time: '',
    end_time: '',
    status: '',
    notes: ''
})

function startEdit(lesson) {
    editingId.value = lesson.id
    editForm.trainer_id = lesson.trainer_id
    editForm.student_id = lesson.student_id
    editForm.branch_id = lesson.branch_id
    editForm.type = lesson.type
    editForm.title = lesson.title
    editForm.start_time = lesson.start_time
    editForm.end_time = lesson.end_time
    editForm.status = lesson.status
    editForm.notes = lesson.notes
}

function cancelEdit() {
    editingId.value = null
}

function updateLesson(id) {
    editForm.put(`/lessons/${id}`, {
        onSuccess: () => editingId.value = null
    })
}

function deleteLesson(id) {
    if (confirm('Delete lesson?')) {
        router.delete(`/lessons/${id}`)
    }
}
</script>

<template>
    <h1>Lessons</h1>

    <p v-if="$page.props.success" style="color:green">
        {{ $page.props.success }}
    </p>

    <form @submit.prevent="form.post('/lessons', {
        onSuccess: () => form.reset()
    })">
        <select v-model="form.trainer_id">
            <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                {{ trainer.last_name }} {{ trainer.first_name }}
            </option>
        </select>

        <select v-model="form.student_id">
            <option v-for="student in students" :key="student.id" :value="student.id">
                {{ student.last_name }} {{ student.first_name }}
            </option>
        </select>

        <select v-model="form.branch_id">
            <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                {{ branch.name }}
            </option>
        </select>

        <select v-model="form.type">
            <option>individual</option>
            <option>group</option>
        </select>

        <input v-model="form.title" placeholder="Title" />
        <p v-if="form.errors.title" style="color:red">{{ form.errors.title }}</p>

        <input type="datetime-local" v-model="form.start_time" placeholder="Start time">
        <p v-if="form.errors.start_time" style="color:red">{{ form.errors.start_time }}</p>

        <input type="datetime-local" v-model="form.end_time" placeholder="End time">
        <p v-if="form.errors.end_time" style="color:red">{{ form.errors.end_time }}</p>

        <select v-model="form.status">
            <option>scheduled</option>
            <option>completed</option>
            <option>cancelled</option>
        </select>

        <textarea v-model="form.notes" placeholder="Notes"></textarea>
        <p v-if="form.errors.notes" style="color:red">{{ form.errors.notes }}</p>

        <button type="submit" :disabled="form.processing">Add</button>
    </form>

    <ul>
        <li v-for="lesson in lessons" :key="lesson.id">
            <template v-if="editingId === lesson.id">
                <select v-model="editForm.trainer_id">
                    <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                        {{ trainer.last_name }} {{ trainer.first_name }}
                    </option>
                </select>

                <select v-model="editForm.student_id">
                    <option v-for="student in students" :key="student.id" :value="student.id">
                        {{ student.last_name }} {{ student.first_name }}
                    </option>
                </select>

                <select v-model="editForm.branch_id">
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                        {{ branch.name }}
                    </option>
                </select>

                <select v-model="editForm.type">
                    <option>individual</option>
                    <option>group</option>
                </select>

                <input v-model="editForm.title" placeholder="Title" />
                <p v-if="editForm.errors.title" style="color:red">{{ editForm.errors.title }}</p>

                <input type="datetime-local" v-model="editForm.start_time" placeholder="Start time">
                <p v-if="editForm.errors.start_time" style="color:red">{{ editForm.errors.start_time }}</p>

                <input type="datetime-local" v-model="editForm.end_time" placeholder="End time">
                <p v-if="editForm.errors.end_time" style="color:red">{{ editForm.errors.end_time }}</p>

                <select v-model="editForm.status">
                    <option>scheduled</option>
                    <option>completed</option>
                    <option>cancelled</option>
                </select>

                <textarea v-model="editForm.notes" placeholder="Notes"></textarea>
                <p v-if="editForm.errors.notes" style="color:red">{{ editForm.errors.notes }}</p>

                <button @click="updateLesson(lesson.id)">Save</button>
                <button @click="cancelEdit()">Cancel</button>
            </template>
            <template v-else>
                {{ lesson.title }} {{ lesson.status }}
                <button @click="startEdit(lesson)">Edit</button>
                <button @click="deleteLesson(lesson.id)">Delete</button>
            </template>
        </li>
    </ul>
</template>
