<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import LessonForm from './Components/LessonForm.vue'

defineProps({ trainers: Array, students: Array, branches: Array })
</script>

<template>
    <AuthenticatedLayout title="Add Lesson">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/lessons" class="text-gray-500 no-underline">Lessons</Link>
                / New Lesson
            </div>
            <h1 class="page-title">Create Lesson</h1>
            <p class="page-subtitle">Schedule a new lesson.</p>
        </div>
        <LessonForm :trainers="trainers" :students="students" :branches="branches" />
    </AuthenticatedLayout>
</template>
