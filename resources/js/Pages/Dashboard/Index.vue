<script setup>
import StatsGrid from '../../Components/StatsGrid.vue';
import RevenueChart from './Components/RevenueChart.vue';
import TournamentsList from './Components/TournamentsList.vue';
import QuickActions from './Components/QuickActions.vue';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';

defineProps({
    stats: Array,
    tournaments: Array,
    revenueData: Array,
})
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <StatsGrid :stats="stats" />
        <div class="grid mt-3">
            <div class="col-12 xl:col-8">
                <RevenueChart :revenueData="revenueData" />
            </div>
            <div class="col-12 xl:col-4">
                <TournamentsList :tournaments="tournaments" />
            </div>
        </div>
        <QuickActions />
    </AuthenticatedLayout>
</template>
