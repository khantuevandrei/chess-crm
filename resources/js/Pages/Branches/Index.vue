<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { InputText, Button, Card, DataTable, Column, Tag } from 'primevue';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import StatsGrid from '../../Components/StatsGrid.vue';

const props = defineProps({
    branches: Array,
    stats: Array,
})

const searchQuery = ref('')

const filteredBranches = computed(() => {
    if (!searchQuery.value) return props.branches
    return props.branches.filter(b => b.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
})

function deleteBranch(id) {
    if (confirm('Delete this branch?')) {
        router.delete(`/branches/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Branches">
        <!-- Stats Cards -->
        <StatsGrid :stats="stats" class="mb-4" />

        <!-- Main Card -->
        <Card>
            <template #content>
                <!-- Toolbar -->
                <div class="flex justify-content-between align-items-center mb-4">
                    <InputText v-model="searchQuery" placeholder="Search branches..." />
                    <Link href="/branches/create" class="p-button no-underline">
                        <i class="pi pi-plus mr-2" /> Add Branch
                    </Link>
                </div>

                <!-- Table -->
                <DataTable :value="filteredBranches" stripedRows size="small" :paginator="true" :rows="10">
                    <Column header="Name" sortable sortField="name">
                        <template #body="{ data }">
                            <div class="font-bold">{{ data.name }}</div>
                            <div class="text-xs text-gray-500">{{ data.short_name || data.type }}</div>
                        </template>
                    </Column>
                    <Column header="Address" sortable sortField="address">
                        <template #body="{ data }">
                            {{ data.address }}, {{ data.city }}
                        </template>
                    </Column>
                    <Column header="Students" field="students_count" />
                    <Column header="Trainers" field="trainers_count" />
                    <Column header="Month Lessons" field="lessons_count" />
                    <Column header="Month Revenue">
                        <template #body="{ data }">
                            ${{ data.payments_sum_amount || 0 }}
                        </template>
                    </Column>
                    <Column header="Status">
                        <template #body="{ data }">
                            <Tag :value="data.status" :severity="data.status === 'active' ? 'success' : 'secondary'" />
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex gap-1">
                                <Link :href="`/branches/${data.id}/edit`"
                                    class="p-button p-button-sm p-button-secondary no-underline">
                                    <i class="pi pi-pencil" />
                                </Link>
                                <Button icon="pi pi-trash" severity="danger" size="small"
                                    @click="deleteBranch(data.id)" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AuthenticatedLayout>
</template>
