<script setup>
import { Card, Avatar } from 'primevue';

defineProps({
    stats: Array
})
</script>

<template>
    <div class="grid">
        <div class="col-12 md:col-6 xl:col-2" v-for="stat in stats" :key="stat.title">
            <Card class="stat-card h-full">
                <template #content>
                    <div class="flex justify-content-between">
                        <div>
                            <div class="stat-title">{{ stat.title }}</div>
                            <div class="stat-value">{{ stat.value }}</div>
                            <div class="stat-change" :class="{ positive: stat.positive }">{{ stat.change }}</div>
                        </div>
                        <Avatar :icon="stat.icon" class="stat-avatar" :class="stat.color" size="xlarge"
                            shape="circle" />
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>
