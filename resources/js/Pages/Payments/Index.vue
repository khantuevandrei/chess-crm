<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { InputText, Button, Card, DataTable, Column, Tag } from 'primevue'
import StatsGrid from '@/Components/StatsGrid.vue'

const props = defineProps({
    payments: Array,
    students: Array,
    stats: Array,
})

const searchQuery = ref('')

const filteredPayments = computed(() => {
    if (!searchQuery.value) return props.payments
    const q = searchQuery.value.toLowerCase()
    return props.payments.filter(p =>
        p.student?.first_name.toLowerCase().includes(q) ||
        p.student?.last_name.toLowerCase().includes(q) ||
        p.id.toString().includes(q)
    )
})

function deletePayment(id) {
    if (confirm('Delete this payment?')) {
        router.delete(`/payments/${id}`)
    }
}
</script>

<template>
    <AuthenticatedLayout title="Payments">
        <StatsGrid :stats="stats" class="mb-4" />

        <Card>
            <template #content>
                <div class="flex justify-content-between align-items-center mb-4">
                    <InputText v-model="searchQuery" placeholder="Search payments..." />
                    <Link href="/payments/create" class="p-button no-underline hidden md:inline-flex">
                        <i class="pi pi-plus mr-2" /> Add Payment
                    </Link>
                    <Link href="/payments/create" class="p-button p-button-sm no-underline md:hidden">
                        <i class="pi pi-plus" />
                    </Link>
                </div>

                <DataTable :value="filteredPayments" stripedRows size="small" :paginator="true" :rows="10"
                    responsiveLayout="scroll">
                    <Column header="Student" sortable sortField="student.last_name">
                        <template #body="{ data }">
                            {{ data.student?.last_name }} {{ data.student?.first_name }}
                        </template>
                    </Column>
                    <Column header="Amount" field="amount" sortable>
                        <template #body="{ data }">
                            ${{ data.amount }}
                        </template>
                    </Column>
                    <Column header="Method" field="method" sortable />
                    <Column header="Date" field="paid_at" sortable />
                    <Column header="Status" sortable sortField="status">
                        <template #body="{ data }">
                            <Tag :value="data.status"
                                :severity="data.status === 'paid' ? 'success' : data.status === 'pending' ? 'warning' : 'danger'" />
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex gap-1">
                                <Link :href="`/payments/${data.id}/edit`"
                                    class="p-button p-button-sm p-button-secondary no-underline">
                                    <i class="pi pi-pencil" />
                                </Link>
                                <Button icon="pi pi-trash" severity="danger" size="small"
                                    @click="deletePayment(data.id)" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AuthenticatedLayout>
</template>
