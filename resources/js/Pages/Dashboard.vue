<script setup>
defineProps({
    stats: Object
})
</script>

<template>
    <h1>Chess CRM Dashboard</h1>

    <div style="display:flex; gap:1rem;">
        <div>
            <h3>Students</h3>
            <p>{{ stats.students_count }}</p>
        </div>
        <div>
            <h3>Trainers</h3>
            <p>{{ stats.trainers_count }}</p>
        </div>
        <div>
            <h3>Branches</h3>
            <p>{{ stats.branches_count }}</p>
        </div>
    </div>

    <div style="display:flex; gap:1rem; margin-top:1rem">
        <div>
            <h3>Today Lessons</h3>
            <p>{{ stats.today_lessons }}</p>
        </div>
        <div>
            <h3>Week Lessons</h3>
            <p>{{ stats.week_lessons }}</p>
        </div>
        <div>
            <h3>Month Payments</h3>
            <p>{{ stats.month_payments }}</p>
        </div>
    </div>

    <h2 style="margin-top:2rem">Upcoming Tournaments</h2>
    <ul>
        <li v-for="t in stats.upcoming_tournaments" :key="t.id">
            {{ t.name }} - {{ t.start_date }}
        </li>
    </ul>
</template>
