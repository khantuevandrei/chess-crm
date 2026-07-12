<script setup>
import { ref } from 'vue';
import { Card, Tag, Divider } from 'primevue';
import Chart from 'primevue/chart';

const chartData = ref({
    labels: ['1 Jun', '5 Jun', '10 Jun', '15 Jun', '20 Jun', '25 Jun', '30 Jun'],
    datasets: [{
        label: 'Revenue',
        data: [2500, 4200, 6100, 8400, 9800, 11400, 12480],
        borderColor: '#7c3aed',
        backgroundColor: 'rgba(124,58,237,.12)',
        fill: true,
        tension: .4
    }]
})

const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    interaction: { intersect: false, mode: 'index' },
    scales: {
        x: { grid: { display: false } },
        y: { beginAtZero: true, grid: { color: '#ececec' } }
    }
})
</script>

<template>
    <Card class="chart-card">
        <template #title>
            <div class="flex justify-content-between align-items-center">
                <span>Monthly Revenue</span>
                <Tag severity="success" value="+18%" />
            </div>
        </template>
        <template #content>
            <Chart type="line" :data="chartData" :options="chartOptions" style="height:360px" />
            <Divider />
            <div class="grid text-center">
                <div class="col">
                    <div class="summary-value">$122</div>
                    <div class="summary-label">Average Check</div>
                </div>
                <div class="col">
                    <div class="summary-value">201</div>
                    <div class="summary-label">Payments</div>
                </div>
                <div class="col">
                    <div class="summary-value">92%</div>
                    <div class="summary-label">Paid</div>
                </div>
            </div>
        </template>
    </Card>
</template>
