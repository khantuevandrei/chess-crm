<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import TournamentForm from './Components/TournamentForm.vue'

defineProps({ tournament: Object })
</script>

<template>
    <AuthenticatedLayout title="Edit Tournament">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/tournaments" class="text-gray-500 no-underline">Tournaments</Link>
                / {{ tournament.name }}
            </div>
            <h1 class="page-title">Edit Tournament</h1>
        </div>
        <TournamentForm :tournament="tournament" />
    </AuthenticatedLayout>
</template>
