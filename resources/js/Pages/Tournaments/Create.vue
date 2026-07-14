<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import TournamentForm from './Components/TournamentForm.vue'
</script>

<template>
    <AuthenticatedLayout title="Add Tournament">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/tournaments" class="text-gray-500 no-underline">Tournaments</Link>
                / New Tournament
            </div>
            <h1 class="page-title">Create Tournament</h1>
        </div>
        <TournamentForm />
    </AuthenticatedLayout>
</template>
