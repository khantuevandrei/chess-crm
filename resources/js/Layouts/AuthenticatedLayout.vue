<script setup>
import Header from '../Pages/Components/Dashboard/Header.vue';
import Sidebar from '../Pages/Components/Sidebar.vue'
</script>

<template>
    <div class="flex">
        <Sidebar />
        <div class="main-content">
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
}
</style>
