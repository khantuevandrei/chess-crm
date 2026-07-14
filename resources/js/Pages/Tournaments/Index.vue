<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { InputText, Button, Card, DataTable, Column, Tag } from 'primevue'
import StatsGrid from '@/Components/StatsGrid.vue'

const props = defineProps({
    tournaments: Array,
    stats: Array,
})

const searchQuery = ref('')

const filteredTournaments = computed(() => {
    if (!searchQuery.value) return props.tournaments
    const q = searchQuery.value.toLowerCase()
    return props.tournaments.filter(t => t.name.toLowerCase().includes(q) || t.location.toLowerCase().includes(q))
})

function deleteTournament(id) {
    if (confirm('Delete this tournament?')) {
        router.delete(`/tournaments/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Tournaments">
        <StatsGrid :stats="stats" class="mb-4" />

        <Card>
            <template #content>
                <div class="flex justify-content-between align-items-center mb-4">
                    <InputText v-model="searchQuery" placeholder="Search tournaments..." />
                    <Link href="/tournaments/create" class="p-button no-underline hidden md:inline-flex">
                        <i class="pi pi-plus mr-2" /> Add Tournament
                    </Link>
                    <Link href="/tournaments/create" class="p-button p-button-sm no-underline md:hidden">
                        <i class="pi pi-plus" />
                    </Link>
                </div>

                <DataTable :value="filteredTournaments" stripedRows size="small" :paginator="true" :rows="10"
                    responsiveLayout="scroll">
                    <Column header="Name" sortable sortField="name">
                        <template #body="{ data }">
                            <Link :href="`/tournaments/${data.id}`" class="font-bold no-underline text-primary">
                                {{ data.name }}
                            </Link>
                        </template>
                    </Column>
                    <Column header="Location" field="location" sortable />
                    <Column header="Start Date" sortable sortField="start_date">
                        <template #body="{ data }">
                            {{ new Date(data.start_date).toLocaleDateString() }}
                        </template>
                    </Column>
                    <Column header="End Date" sortable sortField="end_date">
                        <template #body="{ data }">
                            {{ new Date(data.end_date).toLocaleDateString() }}
                        </template>
                    </Column>
                    <Column header="Type" field="type" sortable />
                    <Column header="Participants" field="tournament_results_count" />
                    <Column header="Status" sortable sortField="status">
                        <template #body="{ data }">
                            <Tag :value="data.status"
                                :severity="data.status === 'active' ? 'success' : data.status === 'upcoming' ? 'info' : data.status === 'completed' ? 'secondary' : 'danger'" />
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex gap-1">
                                <Link :href="`/tournaments/${data.id}/edit`"
                                    class="p-button p-button-sm p-button-secondary no-underline">
                                    <i class="pi pi-pencil" />
                                </Link>
                                <Button icon="pi pi-trash" severity="danger" size="small"
                                    @click="deleteTournament(data.id)" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AuthenticatedLayout>
</template>
