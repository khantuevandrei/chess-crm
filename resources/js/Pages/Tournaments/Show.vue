<script setup>
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    tournament: Object,
    students: Array
})

const form = useForm({
    student_id: '',
    place: '',
    points: '',
    rating_change: ''
})

function addResult() {
    form.post(`/tournaments/${props.tournament.id}/results`, {
        onSuccess: () => form.reset()
    })
}

function deleteResult(tournamentId, resultId) {
    if (confirm('Delete result?')) {
        router.delete(`/tournaments/${tournamentId}/results/${resultId}`)
    }
}
</script>

<template>
    <h1>{{ tournament.name }}</h1>
    <p>{{ tournament.location }} | {{ tournament.start_date }} - {{ tournament.end_date }} | {{ tournament.type }}</p>

    <h2>Results</h2>

    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Place</th>
                <th>Points</th>
                <th>Rating Change</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="result in tournament.tournament_results" :key="result.id">
                <td>{{ result.student?.last_name }} {{ result.student?.first_name }}</td>
                <td>{{ result.place }}</td>
                <td>{{ result.points }}</td>
                <td>{{ result.rating_change }}</td>
                <td>
                    <button @click="deleteResult(tournament.id, result.id)">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Add result</h2>

    <form @submit.prevent="addResult">
        <select v-model="form.student_id">
            <option v-for="student in students" :key="student.id" :value="student.id">
                {{ student.last_name }} {{ student.first_name }}
            </option>
        </select>

        <input type="number" v-model="form.place" placeholder="Place" />
        <input type="number" step="0.5" v-model="form.points" placeholder="Points" />
        <input type="number" v-model="form.rating_change" placeholder="Rating change" />

        <button type="submit" :disabled="form.processing">Add</button>
    </form>
</template>
