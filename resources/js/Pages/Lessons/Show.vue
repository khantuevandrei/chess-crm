<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { Card, Button, Tag } from 'primevue'

defineProps({ lesson: Object })

function deleteLesson(id) {
    if (confirm('Delete this lesson?')) {
        router.delete(`/lessons/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Lesson Details">
        <div class="flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-sm text-gray-500 mb-1">
                    <Link href="/lessons" class="text-gray-500 no-underline">Lessons</Link>
                    / {{ lesson.title }}
                </div>
                <div class="flex align-items-center gap-2">
                    <h1 class="page-title">{{ lesson.title }}</h1>
                    <Tag :value="lesson.status"
                        :severity="lesson.status === 'completed' ? 'success' : lesson.status === 'cancelled' ? 'danger' : 'warning'" />
                </div>
            </div>
            <div class="flex gap-2">
                <Link href="/lessons" class="p-button p-button-secondary no-underline">Back</Link>
            </div>
        </div>

        <div class="grid">
            <div class="col-12 md:col-8">
                <Card class="mb-4">
                    <template #title>Lesson Information</template>
                    <template #content>
                        <div class="grid">
                            <div class="col-6"><strong>Trainer:</strong> {{ lesson.trainer?.last_name }} {{
                                lesson.trainer?.first_name }}</div>
                            <div class="col-6"><strong>Student:</strong> {{ lesson.student?.last_name || 'Group lesson'
                            }}</div>
                            <div class="col-6"><strong>Branch:</strong> {{ lesson.branch?.name }}</div>
                            <div class="col-6"><strong>Type:</strong> {{ lesson.type }}</div>
                            <div class="col-6"><strong>Start:</strong> {{ lesson.start_time }}</div>
                            <div class="col-6"><strong>End:</strong> {{ lesson.end_time }}</div>
                            <div class="col-6"><strong>Students:</strong> {{ lesson.students_count }}</div>
                        </div>
                    </template>
                </Card>
                <Card v-if="lesson.notes">
                    <template #title>Notes</template>
                    <template #content>{{ lesson.notes }}</template>
                </Card>
            </div>
            <div class="col-12 md:col-4">
                <Card class="mb-4">
                    <template #title>Quick Actions</template>
                    <template #content>
                        <div class="flex flex-column gap-2">
                            <Link :href="`/lessons/${lesson.id}/edit`"
                                class="no-underline text-color flex align-items-center gap-2 p-2 hover:bg-gray-100 border-round">
                                <i class="pi pi-pencil" /> Edit Lesson
                            </Link>
                        </div>
                    </template>
                </Card>
                <Card class="border-red-200" style="border: 1px solid #fecaca; background: #fef2f2;">
                    <template #title><span style="color: #dc2626;">Danger Zone</span></template>
                    <template #content>
                        <p class="text-sm text-gray-600 mb-3">Deleting a lesson is irreversible.</p>
                        <Button severity="danger" @click="deleteLesson(lesson.id)" class="w-full">Delete Lesson</Button>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
