<script setup>
import { useForm } from '@inertiajs/vue3'
import { InputText, Button, Card } from 'primevue'

const props = defineProps({
    tournament: { type: Object, default: null },
})

const isEdit = !!props.tournament

const form = useForm({
    name: props.tournament?.name || '',
    location: props.tournament?.location || '',
    start_date: props.tournament?.start_date?.substring(0, 10) || '',
    end_date: props.tournament?.end_date?.substring(0, 10) || '',
    type: props.tournament?.type || '',
    status: props.tournament?.status || 'upcoming',
})

function submit() {
    if (isEdit) {
        form.put(`/tournaments/${props.tournament.id}`)
    } else {
        form.post('/tournaments')
    }
}

function goBack() {
    window.history.back()
}
</script>

<template>
    <form @submit.prevent="submit">
        <Card class="mb-4">
            <template #title>Tournament Details</template>
            <template #content>
                <div class="grid">
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Name *</label>
                        <InputText v-model="form.name" placeholder="Tournament name" class="w-full" />
                        <p v-if="form.errors.name" class="mt-1 text-red-500 text-sm">{{ form.errors.name }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Location *</label>
                        <InputText v-model="form.location" placeholder="Location" class="w-full" />
                        <p v-if="form.errors.location" class="mt-1 text-red-500 text-sm">{{ form.errors.location }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Type *</label>
                        <select v-model="form.type" class="w-full p-2 border-round">
                            <option value="">Select Type</option>
                            <option value="internal">Internal</option>
                            <option value="external">External</option>
                        </select>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Start Date *</label>
                        <InputText type="date" v-model="form.start_date" class="w-full" />
                        <p v-if="form.errors.start_date" class="mt-1 text-red-500 text-sm">{{ form.errors.start_date }}
                        </p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">End Date *</label>
                        <InputText type="date" v-model="form.end_date" class="w-full" />
                        <p v-if="form.errors.end_date" class="mt-1 text-red-500 text-sm">{{ form.errors.end_date }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select v-model="form.status" class="w-full p-2 border-round">
                            <option value="upcoming">Upcoming</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </template>
        </Card>

        <div class="flex justify-content-between">
            <button type="button" @click="goBack" class="p-button p-button-secondary no-underline">← Back</button>
            <Button type="submit" :disabled="form.processing">
                {{ isEdit ? 'Save Changes' : 'Create Tournament' }}
            </Button>
        </div>
    </form>
</template>
