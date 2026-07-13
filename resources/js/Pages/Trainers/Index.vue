<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { InputText, Button, Card, DataTable, Column, Tag } from 'primevue';
import StatsGrid from '../../Components/StatsGrid.vue';

const props = defineProps({
    trainers: Array,
    stats: Array,
})

const searchQuery = ref('')

const filteredTrainers = computed(() => {
    if (!searchQuery.value) return props.trainers
    const q = searchQuery.value.toLowerCase()
    return props.trainers.filter(t =>
        t.first_name.toLowerCase().includes(q) ||
        t.last_name.toLowerCase().includes(q)
    )
})

function deleteTrainer(id) {
    if (confirm('Delete this trainer?')) {
        router.delete(`/trainers/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Trainers">
        <!-- KPI Cards -->
        <StatsGrid :stats="stats" class="mb-4" />

        <!-- Main Card -->
        <Card>
            <template #content>
                <!-- Toolbar -->
                <div class="flex justify-content-between align-items-center mb-4">
                    <InputText v-model="searchQuery" placeholder="Search trainers..." />
                    <Link href="/trainers/create" class="p-button no-underline hidden md:inline-flex">
                        <i class="pi pi-plus mr-2" /> Add Trainer
                    </Link>
                    <Link href="/trainers/create" class="p-button p-button-sm no-underline md:hidden">
                        <i class="pi pi-plus" />
                    </Link>
                </div>

                <!-- Table -->
                <DataTable :value="filteredTrainers" stripedRows size="small" :paginator="true" :rows="10"
                    responsiveLayout="scroll">
                    <Column header="Name" sortable sortField="last_name">
                        <template #body="{ data }">
                            <Link :href="`/trainers/${data.id}`" class="font-bold no-underline text-primary">
                                {{ data.last_name }} {{ data.first_name }}
                            </Link>
                        </template>
                    </Column>
                    <Column header="Branch" sortable sortField="branch.name">
                        <template #body="{ data }">
                            {{ data.branch?.name || 'N/A' }}
                        </template>
                    </Column>
                    <Column header="Specialization" field="specialization" sortable />
                    <Column header="Students" field="students_count" sortable />
                    <Column header="Lessons" field="lessons_count" sortable />
                    <Column header="Status" sortable sortField="status">
                        <template #body="{ data }">
                            <Tag :value="data.status" :severity="data.status === 'active' ? 'success' : 'secondary'" />
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex gap-1">
                                <Link :href="`/trainers/${data.id}/edit`"
                                    class="p-button p-button-sm p-button-secondary no-underline">
                                    <i class="pi pi-pencil" />
                                </Link>
                                <Button icon="pi pi-trash" severity="danger" size="small"
                                    @click="deleteTrainer(data.id)" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AuthenticatedLayout>
</template>
