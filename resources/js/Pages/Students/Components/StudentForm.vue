<script setup>
import { useForm } from '@inertiajs/vue3'
import { InputText, Button, Card } from 'primevue'

const props = defineProps({
    student: { type: Object, default: null },
    branches: { type: Array, required: true },
    trainers: { type: Array, required: true }
})

const isEdit = !!props.student

const form = useForm({
    first_name: props.student?.first_name || '',
    last_name: props.student?.last_name || '',
    birth_date: props.student?.birth_date || '',
    fide_rating: props.student?.fide_rating || '',
    local_rating: props.student?.local_rating || '',
    rank: props.student?.rank || '',
    parent_name: props.student?.parent_name || '',
    parent_phone: props.student?.parent_phone || '',
    branch_id: props.student?.branch_id || '',
    status: props.student?.status || 'active',
    trainer_ids: props.student?.trainers?.map(t => t.id) || [],
})

function submit() {
    if (isEdit) {
        form.put(`/students/${props.student.id}`)
    } else {
        form.post('/students')
    }
}

function goBack() {
    window.history.back()
}
</script>

<template>
    <form @submit.prevent="submit">
        <!-- Student Info Card -->
        <Card class="mb-4">
            <template #title>Student Information</template>
            <template #content>
                <div class="grid">
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">First Name *</label>
                        <InputText v-model="form.first_name" placeholder="First name" class="w-full" />
                        <p v-if="form.errors.first_name" class="mt-1 text-red-500 text-sm">{{ form.errors.first_name }}
                        </p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Last Name *</label>
                        <InputText v-model="form.last_name" placeholder="Last name" class="w-full" />
                        <p v-if="form.errors.last_name" class="mt-1 text-red-500 text-sm">{{ form.errors.last_name }}
                        </p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Birth Date *</label>
                        <InputText type="date" v-model="form.birth_date" class="w-full" />
                        <p v-if="form.errors.birth_date" class="mt-1 text-red-500 text-sm">{{ form.errors.birth_date }}
                        </p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select v-model="form.status" class="w-full p-2 border-round">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">FIDE Rating</label>
                        <InputText type="number" v-model="form.fide_rating" placeholder="FIDE rating" class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Local Rating</label>
                        <InputText type="number" v-model="form.local_rating" placeholder="Local rating"
                            class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Rank</label>
                        <InputText v-model="form.rank" placeholder="Rank (e.g. 1st category)" class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Branch *</label>
                        <select v-model="form.branch_id" class="w-full p-2 border-round">
                            <option value="">Select Branch</option>
                            <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                                {{ branch.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.branch_id" class="mt-1 text-red-500 text-sm">{{ form.errors.branch_id }}
                        </p>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Parent Info Card -->
        <Card class="mb-4">
            <template #title>Parent Information</template>
            <template #content>
                <div class="grid">
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Parent Name *</label>
                        <InputText v-model="form.parent_name" placeholder="Parent name" class="w-full" />
                        <p v-if="form.errors.parent_name" class="mt-1 text-red-500 text-sm">{{ form.errors.parent_name
                            }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Parent Phone *</label>
                        <InputText v-model="form.parent_phone" placeholder="Parent phone" class="w-full" />
                        <p v-if="form.errors.parent_phone" class="mt-1 text-red-500 text-sm">{{ form.errors.parent_phone
                            }}</p>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Trainers Card -->
        <Card class="mb-4">
            <template #title>Trainers</template>
            <template #content>
                <div class="grid">
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Assign Trainers</label>
                        <select v-model="form.trainer_ids" multiple size="5" class="w-full p-2 border-round">
                            <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                                {{ trainer.last_name }} {{ trainer.first_name }}
                            </option>
                        </select>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Action Buttons -->
        <div class="flex justify-content-between">
            <button type="button" @click="goBack" class="p-button p-button-secondary no-underline">← Back</button>
            <Button type="submit" :disabled="form.processing">
                {{ isEdit ? 'Save Changes' : 'Create Student' }}
            </Button>
        </div>
    </form>
</template>
