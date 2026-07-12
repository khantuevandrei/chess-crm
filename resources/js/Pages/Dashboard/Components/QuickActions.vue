<script setup>
import { Card, Button, Avatar } from 'primevue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="grid mt-4">
        <div class="col-12 lg:col-4">
            <Card class="action-card h-full">
                <template #content>
                    <Link href="/lessons/create" class="no-underline">
                        <div class="flex align-items-center gap-4">
                            <Avatar icon="pi pi-calendar-plus" class="action-avatar purple" shape="circle"
                                size="xlarge" />
                            <div class="flex-1">
                                <div class="action-title">Schedule Lesson</div>
                                <div class="action-description">Create a new lesson in timetable</div>
                            </div>
                            <Button icon="pi pi-arrow-right" rounded text />
                        </div>
                    </Link>
                </template>
            </Card>
        </div>
        <div class="col-12 lg:col-4">
            <Card class="action-card h-full">
                <template #content>
                    <Link href="/students" class="no-underline">
                        <div class="flex align-items-center gap-4">
                            <Avatar icon="pi pi-user-plus" class="action-avatar green" shape="circle" size="xlarge" />
                            <div class="flex-1">
                                <div class="action-title">Add Student</div>
                                <div class="action-description">Register a new student</div>
                            </div>
                            <Button icon="pi pi-arrow-right" rounded text />
                        </div>
                    </Link>
                </template>
            </Card>
        </div>
        <div class="col-12 lg:col-4">
            <Card class="action-card h-full">
                <template #content>
                    <Link href="/tournaments" class="no-underline">
                        <div class="flex align-items-center gap-4">
                            <Avatar icon="pi pi-trophy" class="action-avatar gold" shape="circle" size="xlarge" />
                            <div class="flex-1">
                                <div class="action-title">Create Tournament</div>
                                <div class="action-description">Add a new tournament</div>
                            </div>
                            <Button icon="pi pi-arrow-right" rounded text />
                        </div>
                    </Link>
                </template>
            </Card>
        </div>
    </div>
</template>
