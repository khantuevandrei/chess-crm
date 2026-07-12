<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import BranchForm from './Components/BranchForm.vue';

defineProps({ branch: Object })
</script>

<template>
    <AuthenticatedLayout title="Edit Branch">
        <div class="mb-4">
            <div class="text-sm text-gray-500 mb-1">
                <Link href="/branches" class="text-gray-500 no-underline">Branches</Link>
                / {{ branch.name }}
            </div>
            <h1 class="page-title">Edit Branch</h1>
        </div>
        <BranchForm :branch="branch" />
    </AuthenticatedLayout>
</template>
