<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { Card, Button, Tag } from 'primevue'

defineProps({
    student: Object,
})

function deleteStudent(id) {
    if (confirm('Delete this student? All data will be lost.')) {
        router.delete(`/students/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Student Details">
        <!-- Header -->
        <div class="flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-sm text-gray-500 mb-1">
                    <Link href="/students" class="text-gray-500 no-underline">Students</Link>
                    / {{ student.first_name }} {{ student.last_name }}
                </div>
                <div class="flex align-items-center gap-2">
                    <h1 class="page-title">{{ student.first_name }} {{ student.last_name }}</h1>
                    <Tag :value="student.status" :severity="student.status === 'active' ? 'success' : 'secondary'" />
                </div>
            </div>
            <div class="flex gap-2">
                <Link href="/students" class="p-button p-button-secondary no-underline">Back</Link>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid mb-4">
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">FIDE Rating</div>
                            <div class="text-2xl font-bold">{{ student.fide_rating || 'N/A' }}</div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Local Rating</div>
                            <div class="text-2xl font-bold">{{ student.local_rating || 'N/A' }}</div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Rank</div>
                            <div class="text-2xl font-bold">{{ student.rank || 'N/A' }}</div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-6 md:col-3">
                <Card>
                    <template #content>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Branch</div>
                            <div class="text-xl font-bold">{{ student.branch?.name || 'N/A' }}</div>
                        </div>
                    </template>
                </Card>
            </div>
        </div>

        <!-- Details -->
        <div class="grid">
            <div class="col-12 md:col-8">
                <Card class="mb-4">
                    <template #title>Student Information</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6"><strong>First Name:</strong> {{ student.first_name }}</div>
                            <div class="col-6"><strong>Last Name:</strong> {{ student.last_name }}</div>
                            <div class="col-6"><strong>Birth Date:</strong> {{ student.birth_date }}</div>
                            <div class="col-6"><strong>Status:</strong> {{ student.status }}</div>
                        </div>
                    </template>
                </Card>

                <Card class="mb-4">
                    <template #title>Parent Information</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6"><strong>Parent Name:</strong> {{ student.parent_name }}</div>
                            <div class="col-6"><strong>Parent Phone:</strong> {{ student.parent_phone }}</div>
                        </div>
                    </template>
                </Card>

                <Card v-if="student.trainers?.length">
                    <template #title>Trainers</template>
                    <template #content>
                        <ul>
                            <li v-for="trainer in student.trainers" :key="trainer.id">
                                {{ trainer.last_name }} {{ trainer.first_name }}
                            </li>
                        </ul>
                    </template>
                </Card>
            </div>

            <!-- Sidebar -->
            <div class="col-12 md:col-4">
                <Card class="mb-4">
                    <template #title>Quick Actions</template>
                    <template #content>
                        <div class="flex flex-column gap-2">
                            <Link :href="`/students/${student.id}/edit`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-pencil" /> Edit Student
                            </Link>
                            <Link :href="`/lessons/create?student_id=${student.id}`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-calendar-plus" /> Schedule Lesson
                            </Link>
                            <Link :href="`/payments/create?student_id=${student.id}`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-wallet" /> Add Payment
                            </Link>
                        </div>
                    </template>
                </Card>

                <!-- Danger Zone -->
                <Card class="border-red-200" style="border: 1px solid #fecaca; background: #fef2f2;">
                    <template #title><span style="color: #dc2626;">Danger Zone</span></template>
                    <template #content>
                        <p class="text-sm text-gray-600 mb-3">Deleting a student is irreversible.</p>
                        <Button severity="danger" @click="deleteStudent(student.id)" class="w-full">Delete
                            Student</Button>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
