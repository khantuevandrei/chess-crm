<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import TrainerForm from './Components/TrainerForm.vue'

defineProps({ branches: Array })
</script>

<template>
    <AuthenticatedLayout title="Add Trainer">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/trainers" class="text-gray-500 no-underline">Trainers</Link>
                / New Trainer
            </div>
            <h1 class="page-title">Create Trainer</h1>
            <p class="page-subtitle">Fill in the information about the new trainer.</p>
        </div>
        <TrainerForm :branches="branches" />
    </AuthenticatedLayout>
</template>
