<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import TrainerForm from './Components/TrainerForm.vue'

defineProps({ trainer: Object, branches: Array })
</script>

<template>
    <AuthenticatedLayout title="Edit Trainer">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/trainers" class="text-gray-500 no-underline">Trainers</Link>
                / {{ trainer.first_name }} {{ trainer.last_name }}
            </div>
            <h1 class="page-title">Edit Trainer</h1>
        </div>
        <TrainerForm :trainer="trainer" :branches="branches" />
    </AuthenticatedLayout>
</template>
