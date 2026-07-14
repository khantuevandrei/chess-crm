<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { InputText, Button, Card, DataTable, Column, Tag } from 'primevue'
import StatsGrid from '@/Components/StatsGrid.vue'

const props = defineProps({
    lessons: Array,
    trainers: Array,
    students: Array,
    branches: Array,
    stats: Array,
})

const searchQuery = ref('')

const filteredLessons = computed(() => {
    if (!searchQuery.value) return props.lessons
    const q = searchQuery.value.toLowerCase()
    return props.lessons.filter(l =>
        l.title.toLowerCase().includes(q) ||
        l.trainer?.first_name.toLowerCase().includes(q) ||
        l.trainer?.last_name.toLowerCase().includes(q) ||
        l.branch?.name.toLowerCase().includes(q)
    )
})

function deleteLesson(id) {
    if (confirm('Delete this lesson?')) {
        router.delete(`/lessons/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Lessons">
        <!-- KPI Cards -->
        <StatsGrid :stats="stats" class="mb-4" />

        <!-- Main Card -->
        <Card>
            <template #content>
                <!-- Toolbar -->
                <div class="flex justify-content-between align-items-center mb-4">
                    <InputText v-model="searchQuery" placeholder="Search lessons..." />
                    <Link href="/lessons/create" class="p-button no-underline hidden md:inline-flex">
                        <i class="pi pi-plus mr-2" /> Add Lesson
                    </Link>
                    <Link href="/lessons/create" class="p-button p-button-sm no-underline md:hidden">
                        <i class="pi pi-plus" />
                    </Link>
                </div>

                <!-- Table -->
                <DataTable :value="filteredLessons" stripedRows size="small" :paginator="true" :rows="10"
                    responsiveLayout="scroll">
                    <Column header="Title" sortable sortField="title">
                        <template #body="{ data }">
                            <Link :href="`/lessons/${data.id}`" class="font-bold no-underline text-primary">
                                {{ data.title }}
                            </Link>
                        </template>
                    </Column>
                    <Column header="Trainer" sortable sortField="trainer.last_name">
                        <template #body="{ data }">
                            {{ data.trainer?.last_name || 'N/A' }}
                        </template>
                    </Column>
                    <Column header="Branch" sortable sortField="branch.name">
                        <template #body="{ data }">
                            {{ data.branch?.name || 'N/A' }}
                        </template>
                    </Column>
                    <Column header="Type" field="type" sortable />
                    <Column header="Start Time" field="start_time" sortable />
                    <Column header="End Time" field="end_time" sortable />
                    <Column header="Status" sortable sortField="status">
                        <template #body="{ data }">
                            <Tag :value="data.status"
                                :severity="data.status === 'completed' ? 'success' : data.status === 'cancelled' ? 'danger' : 'warning'" />
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex gap-1">
                                <Link :href="`/lessons/${data.id}/edit`"
                                    class="p-button p-button-sm p-button-secondary no-underline">
                                    <i class="pi pi-pencil" />
                                </Link>
                                <Button icon="pi pi-trash" severity="danger" size="small"
                                    @click="deleteLesson(data.id)" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AuthenticatedLayout>
</template>
