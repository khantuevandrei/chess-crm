<script setup>
import StatsGrid from './Components/Dashboard/StatsGrid.vue';
import RevenueChart from './Components/Dashboard/RevenueChart.vue';
import TournamentsList from './Components/Dashboard/TournamentsList.vue';
import QuickActions from './Components/Dashboard/QuickActions.vue';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue';

defineProps({
    stats: Array,
    tournaments: Array
})
</script>

<template>
    <AuthenticatedLayout>
        <StatsGrid :stats="stats" />
        <div class="grid mt-3">
            <div class="col-12 xl:col-8">
                <RevenueChart />
            </div>
            <div class="col-12 xl:col-4">
                <TournamentsList :tournaments="tournaments" />
            </div>
        </div>
        <QuickActions />
    </AuthenticatedLayout>
</template>
