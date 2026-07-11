<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    tournaments: Array
})

const form = useForm({
    name: '',
    location: '',
    start_date: '',
    end_date: '',
    type: ''
})

const editingId = ref(null)
const editForm = useForm({
    name: '',
    location: '',
    start_date: '',
    end_date: '',
    type: ''
})

function startEdit(tournament) {
    editingId.value = tournament.id
    editForm.name = tournament.name
    editForm.location = tournament.location
    editForm.start_date = tournament.start_date
    editForm.end_date = tournament.end_date
    editForm.type = tournament.type
}

function cancelEdit() {
    editingId.value = null
}

function updateTournament(id) {
    editForm.put(`/tournaments/${id}`, {
        onSuccess: () => editingId.value = null
    })
}

function deleteTournament(id) {
    if (confirm('Delete tournament?')) {
        router.delete(`/tournaments/${id}`)
    }
}
</script>

<template>
    <h1>Tournaments</h1>

    <p v-if="$page.props.success" style="color:green">
        {{ $page.props.success }}
    </p>

    <form @submit.prevent="form.post(`/tournaments`, {
        onSuccess: () => form.reset()
    })">
        <input v-model="form.name" placeholder="Name">
        <p v-if="form.errors.name" style="color:red">{{ form.errors.name }}</p>

        <input v-model="form.location" placeholder="Location">
        <p v-if="form.errors.location" style="color:red">{{ form.errors.location }}</p>

        <input type="date" v-model="form.start_date" placeholder="Start date">
        <p v-if="form.errors.start_date" style="color:red">{{ form.errors.start_date }}</p>

        <input type="date" v-model="form.end_date" placeholder="End date">
        <p v-if="form.errors.end_date" style="color:red">{{ form.errors.end_date }}</p>

        <input v-model="form.type" placeholder="Type">
        <p v-if="form.errors.type" style="color:red">{{ form.errors.type }}</p>

        <button type="submit" :disabled="form.processing">Add</button>
    </form>

    <ul>
        <li v-for="tournament in tournaments" :key="tournament.id">
            <template v-if="editingId === tournament.id">
                <input v-model="editForm.name" placeholder="Name">
                <p v-if="editForm.errors.name" style="color:red">{{ editForm.errors.name }}</p>

                <input v-model="editForm.location" placeholder="Location">
                <p v-if="editForm.errors.location" style="color:red">{{ editForm.errors.location }}</p>

                <input type="date" v-model="editForm.start_date" placeholder="Start date">
                <p v-if="editForm.errors.start_date" style="color:red">{{ editForm.errors.start_date }}</p>

                <input type="date" v-model="editForm.end_date" placeholder="End date">
                <p v-if="editForm.errors.end_date" style="color:red">{{ editForm.errors.end_date }}</p>

                <input v-model="editForm.type" placeholder="Type">
                <p v-if="editForm.errors.type" style="color:red">{{ editForm.errors.type }}</p>

                <button @click="updateTournament(tournament.id)">Update</button>
                <button @click="cancelEdit()">Cancel</button>
            </template>
            <template v-else>
                {{ tournament.name }} - {{ tournament.location }} -
                {{ tournament.start_date }} - {{ tournament.end_date }}
                <a :href="`/tournaments/${tournament.id}`">View</a>
                <button @click="startEdit(tournament)">Edit</button>
                <button @click="deleteTournament(tournament.id)">Delete</button>
            </template>
        </li>
    </ul>
</template>
