<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { InputText, Button, Card, DataTable, Column, Tag } from 'primevue';
import StatsGrid from '@/Components/StatsGrid.vue';

const props = defineProps({
    students: Array,
    branches: Array,
    trainers: Array,
    stats: Array
})

const searchQuery = ref('')

const filteredStudents = computed(() => {
    if (!searchQuery.value) return props.students
    const q = searchQuery.value.toLocaleLowerCase()
    return props.students.filter(t =>
        t.first_name.toLocaleLowerCase().includes(q) ||
        t.last_name.toLocaleLowerCase().includes(q)
    )
})

function deleteStudent(id) {
    if (confirm('Delete this student?')) {
        router.delete(`/students/${id}`)
    }
}
</script>


<template>
    <AuthenticatedLayout title="Students">
        <!-- Stats Cards-->
        <StatsGrid :stats="stats" class="mb-4" />

        <!-- Main Card -->
        <Card>
            <template #content>
                <!-- Toolbar -->
                <div class="flex justify-content-between align-items-center mb-4">
                    <InputText v-model="searchQuery" placeholder="Search students..." />
                    <Link href="/students/create" class="p-button no-underline hidden md:inline-flex">
                        <i class="pi pi-plus mr-2" /> Add Student
                    </Link>
                    <Link href="/students/create" class="p-button p-button-sm no-underline md:hidden">
                        <i class="pi pi-plus" />
                    </Link>
                </div>

                <!-- Table -->
                <DataTable :value="filteredStudents" stripedRows size="small" :paginator="true" :rows="10">
                    <Column header="Name" sortable sort-field="last_name">
                        <template #body="{ data }">
                            <Link :href="`/students/${data.id}`" class="font-bold no-underline text-primary">
                                {{ data.last_name }} {{ data.first_name }}
                            </Link>
                        </template>
                    </Column>
                    <Column header="Birth Date" field="birth_date" sortable />
                    <Column header="Branch" sortable sort-field="branch.name">
                        <template #body="{ data }">
                            {{ data.branch?.name || 'N/A' }}
                        </template>
                    </Column>
                    <Column header="Trainer" sortable sort-field="trainers.last_name">
                        <template #body="{ data }">
                            {{ data.trainers?.[0]?.last_name + ' ' + data.trainers?.[0]?.first_name || 'N/A' }}
                        </template>
                    </Column>
                    <Column header="FIDE Rating" field="fide_rating" sortable />
                    <Column header="Status" sortable sort-field="status">
                        <template #body="{ data }">
                            <Tag :value="data.status" :severity="data.status === 'active' ? 'success' : 'secondary'" />
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex gap-1">
                                <Link :href="`/students/${data.id}/edit`"
                                    class="p-button p-button-sm p-button-secondary no-underline">
                                    <i class="pi pi-pencil" />
                                </Link>
                                <Button icon="pi pi-trash" severity="danger" size="small"
                                    @click="deleteStudent(data.id)" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AuthenticatedLayout>
</template>
