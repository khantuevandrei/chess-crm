<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { Card, Button, Tag } from 'primevue';
import StatsGrid from '../../Components/StatsGrid.vue';

defineProps({
    trainer: Object,
})

function deleteTrainer(id) {
    if (confirm('Delete this trainer? All data will be lost.')) {
        router.delete(`/trainers/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Trainer Details">
        <!-- Header -->
        <div class="flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-sm text-gray-500 mb-1">
                    <Link href="/trainers" class="text-gray-500 no-underline">Trainers</Link>
                    / {{ trainer.first_name }} {{ trainer.last_name }}
                </div>
                <div class="flex align-items-center gap-2">
                    <h1 class="page-title">{{ trainer.first_name }} {{ trainer.last_name }}</h1>
                    <Tag :value="trainer.status" :severity="trainer.status === 'active' ? 'success' : 'secondary'" />
                </div>
            </div>
            <div class="flex gap-2">
                <Link href="/trainers" class="p-button p-button-secondary no-underline">Back</Link>
                <Link :href="`/trainers/${trainer.id}/edit`" class="p-button p-button-secondary no-underline">Edit
                </Link>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid mb-4">
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Students</div>
                            <div class="text-2xl font-bold">{{ trainer.students_count }}</div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Lessons</div>
                            <div class="text-2xl font-bold">{{ trainer.lessons_count }}</div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Rating</div>
                            <div class="text-2xl font-bold">{{ trainer.rating ? Number(trainer.rating).toFixed(2) :
                                'N/A' }}</div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Branch</div>
                            <div class="text-xl font-bold">{{ trainer.branch?.name || 'N/A' }}</div>
                        </div>
                    </template>
                </Card>
            </div>
        </div>

        <!-- Details -->
        <div class="grid">
            <div class="col-12 md:col-8">
                <Card class="mb-4">
                    <template #title>Information</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6"><strong>First Name:</strong> {{ trainer.first_name }}</div>
                            <div class="col-6"><strong>Last Name:</strong> {{ trainer.last_name }}</div>
                            <div class="col-6"><strong>Email:</strong> {{ trainer.email }}</div>
                            <div class="col-6"><strong>Phone:</strong> {{ trainer.phone }}</div>
                            <div class="col-6"><strong>Specialization:</strong> {{ trainer.specialization }}</div>
                            <div class="col-6"><strong>Status:</strong> {{ trainer.status }}</div>
                        </div>
                    </template>
                </Card>

                <Card v-if="trainer.bio" class="mb-4">
                    <template #title>Bio</template>
                    <template #content>
                        <p>{{ trainer.bio }}</p>
                    </template>
                </Card>

                <Card v-if="trainer.notes">
                    <template #title>Notes</template>
                    <template #content>
                        <p>{{ trainer.notes }}</p>
                    </template>
                </Card>
            </div>

            <!-- Sidebar -->
            <div class="col-12 md:col-4">
                <Card class="mb-4">
                    <template #title>Quick Actions</template>
                    <template #content>
                        <div class="flex flex-column gap-2">
                            <Link :href="`/trainers/${trainer.id}/edit`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-pencil" /> Edit Trainer
                            </Link>
                            <Link :href="`/students/create?trainer_id=${trainer.id}`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-user-plus" /> Add Student
                            </Link>
                            <Link :href="`/lessons/create?trainer_id=${trainer.id}`"
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
                        <p class="text-sm text-gray-600 mb-3">Deleting a trainer is irreversible.</p>
                        <Button severity="danger" @click="deleteTrainer(trainer.id)" class="w-full">Delete
                            Trainer</Button>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
