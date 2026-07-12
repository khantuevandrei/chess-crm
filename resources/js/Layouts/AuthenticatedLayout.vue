<script setup>
import Header from '../Pages/Components/Dashboard/Header.vue';
import Sidebar from '../Pages/Components/Sidebar.vue'
import { ref } from 'vue';

const sidebarOpen = ref(false)
</script>

<template>
    <div class="flex">
        <!-- Mobile overlay -->
        <div v-if="sidebarOpen" class="sidebar-overlay" @click="sidebarOpen = false" />

        <Sidebar :class="{ 'sidebar-mobile-open': sidebarOpen }" />

        <div class="main-content">
            <div class="flex align-items-center justify-content-between gap-3 mb-3 md:hidden">
                <button @click="sidebarOpen = !sidebarOpen" class="hamburger">
                    <i class="pi pi-bars" />
                </button>
            </div>
            <Header />
            <slot />
        </div>
    </div>
</template>

<style scoped>
.main-content {
    margin-left: 240px;
    flex: 1;
    padding: 2rem;
    background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
    min-height: 100vh;
    max-width: calc(100vw - 240px);
    overflow-x: hidden;
}

.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .5);
    z-index: 40;
}

.hamburger {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #1f2937;
}

@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        max-width: 100vw;
        padding: 1rem;
    }

    .sidebar-overlay {
        display: block;
    }

    .sidebar {
        transform: translateX(-100%);
        transition: transform .3s;
        z-index: 50;
    }

    .sidebar-mobile-open {
        transform: translateX(0);
    }
}
</style>
