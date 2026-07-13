<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { InputText, Button, Card } from 'primevue';

const props = defineProps({
    trainer: { type: Object, default: null },
    branches: { type: Object, required: true }
})

const isEdit = !!props.trainer

const form = useForm({
    first_name: props.trainer?.first_name || '',
    last_name: props.trainer?.last_name || '',
    email: props.trainer?.email || '',
    phone: props.trainer?.phone || '',
    specialization: props.trainer?.specialization || '',
    rating: props.trainer?.rating || '',
    branch_id: props.trainer?.branch_id || '',
    status: props.trainer?.status || 'active',
    bio: props.trainer?.bio || '',
    notes: props.trainer?.notes || '',
})

function submit() {
    if (isEdit) {
        form.put(`/trainers/${props.trainer.id}`)
    } else {
        form.post('/trainers')
    }
}
</script>

<template>
    <form @submit.prevent="submit">
        <!-- Basic Information Card -->
        <Card class="mb-4">
            <template #title>Basic Information</template>
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
                        <label class="text-sm text-gray-600 mb-1 block">Email *</label>
                        <InputText v-model="form.email" type="email" placeholder="Email" class="w-full" />
                        <p v-if="form.errors.email" class="mt-1 text-red-500 text-sm">{{ form.errors.email }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Phone *</label>
                        <InputText v-model="form.phone" placeholder="Phone" class="w-full" />
                        <p v-if="form.errors.phone" class="mt-1 text-red-500 text-sm">{{ form.errors.phone }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Specialization *</label>
                        <InputText v-model="form.specialization" placeholder="e.g. Tactics, Openings" class="w-full" />
                        <p v-if="form.errors.specialization" class="mt-1 text-red-500 text-sm">{{
                            form.errors.specialization }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Rating</label>
                        <InputText v-model="form.rating" type="number" placeholder="Rating (e.g. 2400)"
                            class="w-full" />
                        <p v-if="form.errors.rating" class="mt-1 text-red-500 text-sm">{{ form.errors.rating }}</p>
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
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select v-model="form.status" class="w-full p-2 border-round">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Additional Information Card -->
        <Card class="mb-4">
            <template #title>Additional Information</template>
            <template #content>
                <div class="grid">
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Bio</label>
                        <textarea v-model="form.bio" rows="4" placeholder="Write a short bio..."
                            class="w-full p-2 border-round"></textarea>
                        <p v-if="form.errors.bio" class="mt-1 text-red-500 text-sm">{{ form.errors.bio }}</p>
                    </div>
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Notes</label>
                        <textarea v-model="form.notes" rows="4" placeholder="Internal notes..."
                            class="w-full p-2 border-round"></textarea>
                        <p v-if="form.errors.notes" class="mt-1 text-red-500 text-sm">{{ form.errors.notes }}</p>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Action Buttons -->
        <div class="flex justify-content-between">
            <Link :href="`/trainers/${trainer.id}`" class="p-button p-button-secondary no-underline">Cancel</Link>
            <Button type="submit" :disabled="form.processing">
                {{ isEdit ? 'Save Changes' : 'Create Trainer' }}
            </Button>
        </div>
    </form>
</template>
