<script setup>
import { Button } from 'primevue';
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const user = page.props.auth.user
</script>

<template>
    <div class="flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <span class="page-subtitle">Welcome back, {{ user?.name || 'Administrator' }}</span>
        </div>
        <div class="flex align-items-center gap-3">
            <Button icon="pi pi-bell" severity="secondary" rounded text />
        </div>
    </div>
</template>

<style scoped>
.page-title {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
}

.page-subtitle {
    color: #6b7280;
    font-size: .95rem;
}
</style>
