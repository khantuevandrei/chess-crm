<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import LessonForm from './Components/LessonForm.vue'

defineProps({ lesson: Object, trainers: Array, students: Array, branches: Array })
</script>

<template>
    <AuthenticatedLayout title="Edit Lesson">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/lessons" class="text-gray-500 no-underline">Lessons</Link>
                / {{ lesson.title }}
            </div>
            <h1 class="page-title">Edit Lesson</h1>
        </div>
        <LessonForm :lesson="lesson" :trainers="trainers" :students="students" :branches="branches" />
    </AuthenticatedLayout>
</template>
