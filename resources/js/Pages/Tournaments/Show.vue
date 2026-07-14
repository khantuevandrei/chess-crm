<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { Card, Button, Tag, DataTable, Column, InputText } from 'primevue'

const props = defineProps({
    tournament: Object,
    students: Array,
})

const form = useForm({
    student_id: '',
    place: '',
    points: '',
    rating_change: '',
})

function addResult() {
    form.post(`/tournaments/${props.tournament.id}/results`, {
        onSuccess: () => form.reset(),
    })
}

function deleteResult(tournamentId, resultId) {
    if (confirm('Delete this result?')) {
        router.delete(`/tournaments/${tournamentId}/results/${resultId}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Tournament Details">
        <div class="flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-sm text-gray-500 mb-1">
                    <Link href="/tournaments" class="text-gray-500 no-underline">Tournaments</Link>
                    / {{ tournament.name }}
                </div>
                <div class="flex align-items-center gap-2">
                    <h1 class="page-title">{{ tournament.name }}</h1>
                    <Tag :value="tournament.status"
                        :severity="tournament.status === 'active' ? 'success' : tournament.status === 'upcoming' ? 'info' : tournament.status === 'completed' ? 'secondary' : 'danger'" />
                </div>
            </div>
            <div class="flex gap-2">
                <Link href="/tournaments" class="p-button p-button-secondary no-underline">Back</Link>
            </div>
        </div>

        <div class="grid mb-4">
            <div class="col-12 md:col-8">
                <Card class="mb-4">
                    <template #title>Tournament Information</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6"><strong>Name:</strong> {{ tournament.name }}</div>
                            <div class="col-6"><strong>Location:</strong> {{ tournament.location }}</div>
                            <div class="col-6"><strong>Type:</strong> {{ tournament.type }}</div>
                            <div class="col-6"><strong>Status:</strong> {{ tournament.status }}</div>
                            <div class="col-6"><strong>Start:</strong> {{ new
                                Date(tournament.start_date).toLocaleDateString()
                            }}</div>
                            <div class="col-6"><strong>End:</strong> {{ new
                                Date(tournament.end_date).toLocaleDateString() }}</div>
                        </div>
                    </template>
                </Card>

                <!-- Results -->
                <Card>
                    <template #title>Results</template>
                    <template #content>
                        <DataTable :value="tournament.tournament_results" stripedRows size="small"
                            v-if="tournament.tournament_results?.length">
                            <Column header="Student">
                                <template #body="{ data }">
                                    {{ data.student?.last_name }} {{ data.student?.first_name }}
                                </template>
                            </Column>
                            <Column header="Place" field="place" />
                            <Column header="Points" field="points" />
                            <Column header="Rating Change" field="rating_change" />
                            <Column header="Actions">
                                <template #body="{ data }">
                                    <Button icon="pi pi-trash" severity="danger" size="small"
                                        @click="deleteResult(tournament.id, data.id)" />
                                </template>
                            </Column>
                        </DataTable>
                        <p v-else class="text-gray-500">No results yet.</p>
                    </template>
                </Card>
            </div>

            <!-- Sidebar -->
            <div class="col-12 md:col-4">
                <Card class="mb-4">
                    <template #title>Quick Actions</template>
                    <template #content>
                        <div class="flex flex-column gap-2">
                            <Link :href="`/tournaments/${tournament.id}/edit`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-pencil" /> Edit Tournament
                            </Link>
                            <Link :href="`/students/create?branch_id=${tournament.id}`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-user-plus" /> Add Participant
                            </Link>
                        </div>
                    </template>
                </Card>
                <!-- Add Result Form -->
                <Card class="mb-4">
                    <template #title>Add Result</template>
                    <template #content>
                        <form @submit.prevent="addResult">
                            <div class="flex flex-column gap-3">
                                <div>
                                    <label class="text-sm text-gray-600 mb-1 block">Student *</label>
                                    <select v-model="form.student_id" class="w-full p-2 border-round">
                                        <option value="">Select Student</option>
                                        <option v-for="student in students" :key="student.id" :value="student.id">
                                            {{ student.last_name }} {{ student.first_name }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600 mb-1 block">Place *</label>
                                    <InputText v-model="form.place" type="number" placeholder="Place" class="w-full" />
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600 mb-1 block">Points *</label>
                                    <InputText v-model="form.points" type="number" step="0.5" placeholder="Points"
                                        class="w-full" />
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600 mb-1 block">Rating Change</label>
                                    <InputText v-model="form.rating_change" type="number" placeholder="Rating change"
                                        class="w-full" />
                                </div>
                                <Button type="submit" :disabled="form.processing">Add Result</Button>
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
