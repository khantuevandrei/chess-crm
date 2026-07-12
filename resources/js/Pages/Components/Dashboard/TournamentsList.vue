<script setup>
import { Card, Button, Avatar, Tag, Divider } from 'primevue';
import { Link } from '@inertiajs/vue3';

defineProps({
    tournaments: Array
})
</script>

<template>
    <Card class="tournament-card">
        <template #title>
            <div class="flex justify-content-between align-items-center">
                <span>Upcoming Tournaments</span>
                <Button label="View all" text size="small" />
            </div>
        </template>
        <template #content>
            <Link v-for="tournament in tournaments" :key="tournament.id" :href="`/tournaments/${tournament.id}`"
                class="tournament-item no-underline">
                <div class="flex gap-3 align-items-start">
                    <Avatar :icon="tournament.icon" shape="square" size="xlarge"
                        :class="['tournament-avatar', tournament.color]" />
                    <div class="flex-1">
                        <div class="tournament-title">{{ tournament.name }}</div>
                        <div class="tournament-date"><i class="pi pi-calendar mr-2" />{{ tournament.date }}</div>
                        <div class="tournament-place"><i class="pi pi-map-marker mr-2" />{{ tournament.location }}</div>
                        <div class="mt-2">
                            <Tag :value="tournament.type" severity="secondary" />
                        </div>
                    </div>
                </div>
                <Divider />
            </Link>
        </template>
    </Card>
</template>
