<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Avatar } from 'primevue';

defineProps({
    class: String
})

const page = usePage()
const user = page.props.auth.user

const menu = [
    { label: 'Dashboard', icon: 'pi pi-th-large', url: '/dashboard' },
    { label: 'Students', icon: 'pi pi-users', url: '/students' },
    { label: 'Trainers', icon: 'pi pi-user', url: '/trainers' },
    { label: 'Branches', icon: 'pi pi-building', url: '/branches' },
    { label: 'Schedule', icon: 'pi pi-calendar', url: '/lessons' },
    { label: 'Payments', icon: 'pi pi-wallet', url: '/payments' },
    { label: 'Tournaments', icon: 'pi pi-trophy', url: '/tournaments' },
]

function isActive(url) {
    if (url === '/dashboard') return page.url === '/' || page.url.startsWith('/dashboard')
    return page.url.startsWith(url)
}
</script>

<template>
    <div class="sidebar" :class="class">
        <div class="sidebar-header">
            <span class="text-xl font-bold">♟ Chess CRM</span>
        </div>
        <nav class="sidebar-nav">
            <Link v-for="item in menu" :key="item.url" :href="item.url"
                :class="['sidebar-item', { active: isActive(item.url) }]">
                <i :class="item.icon" class="mr-2" />
                <span>{{ item.label }}</span>
            </Link>
        </nav>
        <div class="sidebar-footer">
            <Avatar icon="pi pi-user" shape="circle" />
            <div class="ml-2">
                <div class="text-sm font-medium">{{ user?.name || 'Admin' }}</div>
                <div class="text-xs text-gray-400">{{ user?.email || 'admin@crm.com' }}</div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.sidebar {
    width: 240px;
    background: #111827;
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #1f2937;
}

.sidebar-nav {
    flex: 1;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.sidebar-item {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    color: #9ca3af;
    text-decoration: none;
    transition: all 0.2s;
}

.sidebar-item:hover {
    background: #1f2937;
    color: white;
}

.sidebar-item.active {
    background: #1f2937;
    color: white;
    border-left: 3px solid #7c3aed;
}

.sidebar-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #1f2937;
    display: flex;
    align-items: center;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform .3s;
        z-index: 50;
        display: flex;
    }
}
</style>
