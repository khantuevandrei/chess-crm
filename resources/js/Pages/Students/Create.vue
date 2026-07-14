<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import StudentForm from './Components/StudentForm.vue'

defineProps({ branches: Array, trainers: Array })
</script>

<template>
    <AuthenticatedLayout title="Add Student">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/students" class="text-gray-500 no-underline">Students</Link>
                / New Student
            </div>
            <h1 class="page-title">Create Student</h1>
            <p class="page-subtitle">Fill in the information about the new student.</p>
        </div>
        <StudentForm :branches="branches" :trainers="trainers" />
    </AuthenticatedLayout>
</template>
