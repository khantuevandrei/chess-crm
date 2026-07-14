<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import StudentForm from './Components/StudentForm.vue'

defineProps({ student: Object, branches: Array, trainers: Array })
</script>

<template>
    <AuthenticatedLayout title="Edit Student">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/students" class="text-gray-500 no-underline">Students</Link>
                / {{ student.first_name }} {{ student.last_name }}
            </div>
            <h1 class="page-title">Edit Student</h1>
        </div>
        <StudentForm :student="student" :branches="branches" :trainers="trainers" />
    </AuthenticatedLayout>
</template>
