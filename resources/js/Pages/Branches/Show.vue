<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { Card, Button, Tag } from 'primevue';
import StatsGrid from '../../Components/StatsGrid.vue';

defineProps({
    branch: Object,
    stats: Array,
})

function deleteBranch(id) {
    if (confirm('Delete this branch? All data will be lost.')) {
        router.delete(`/branches/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Branch Details">
        <!-- Header -->
        <div class="flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-sm text-gray-500 mb-1">
                    <Link href="/branches" class="text-gray-500 no-underline">Branches</Link>
                    / {{ branch.name }}
                </div>
                <div class="flex align-items-center gap-2">
                    <h1 class="page-title">{{ branch.name }}</h1>
                    <Tag :value="branch.status" :severity="branch.status === 'active' ? 'success' : 'secondary'" />
                </div>
                <p class="text-gray-500 mt-2" v-if="branch.description">{{ branch.description }}</p>
            </div>
        </div>

        <!-- KPI Cards -->
        <StatsGrid :stats="stats" class="mb-4" />

        <div class="grid">
            <!-- Main Info -->
            <div class="col-12 md:col-8">
                <Card class="mb-4">
                    <template #title>Information</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6"><strong>Name:</strong> {{ branch.name }}</div>
                            <div class="col-6"><strong>Type:</strong> {{ branch.type }}</div>
                            <div class="col-6"><strong>Code:</strong> {{ branch.code || 'N/A' }}</div>
                            <div class="col-6"><strong>Opening Date:</strong> {{ branch.opening_date || 'N/A' }}</div>
                            <div class="col-6"><strong>Status:</strong> {{ branch.status }}</div>
                            <div class="col-6"><strong>Short Name:</strong> {{ branch.short_name || 'N/A' }}</div>
                        </div>
                    </template>
                </Card>

                <Card class="mb-4">
                    <template #title>Address & Contacts</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-12"><strong>Address:</strong> {{ branch.address }}</div>
                            <div class="col-6"><strong>City:</strong> {{ branch.city || 'N/A' }}</div>
                            <div class="col-6"><strong>Phone:</strong> {{ branch.phone }}</div>
                            <div class="col-6"><strong>Email:</strong> {{ branch.email || 'N/A' }}</div>
                            <div class="col-6"><strong>Website:</strong> {{ branch.website || 'N/A' }}</div>
                            <div class="col-6"><strong>Postal Code:</strong> {{ branch.postal_code || 'N/A' }}</div>
                        </div>
                    </template>
                </Card>

                <Card v-if="branch.capacity || branch.area">
                    <template #title>Additional Info</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6" v-if="branch.capacity"><strong>Capacity:</strong> {{ branch.capacity }}
                            </div>
                            <div class="col-6" v-if="branch.area"><strong>Area:</strong> {{ branch.area }} m²</div>
                        </div>
                    </template>
                </Card>
            </div>

            <!-- Sidebar -->
            <div class="col-12 md:col-4">
                <Card class="mb-4">
                    <template #title>Quick Actions</template>
                    <template #content>
                        <div class="flex flex-column gap-2">
                            <Link :href="`/branches/${branch.id}/edit`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-pencil" /> Edit Branch
                            </Link>
                            <Link href="/students/create"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-user-plus" /> Add Student
                            </Link>
                            <Link href="/lessons/create"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-calendar-plus" /> Schedule Lesson
                            </Link>
                        </div>
                    </template>
                </Card>

                <!-- Danger Zone -->
                <Card class="border-red-200" style="border: 1px solid #fecaca; background: #fef2f2;">
                    <template #title><span style="color: #dc2626;">Danger Zone</span></template>
                    <template #content>
                        <p class="text-sm text-gray-600 mb-3">Deleting a branch is irreversible. All associated data
                            will be lost.</p>
                        <Button severity="danger" @click="deleteBranch(branch.id)" class="w-full">Delete Branch</Button>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
