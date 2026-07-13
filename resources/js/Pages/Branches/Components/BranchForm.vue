<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { InputText, Button, Card } from 'primevue';

const props = defineProps({
    branch: Object
})

const isEdit = !!props.branch

const form = useForm({
    name: props.branch?.name || '',
    type: props.branch?.type || 'main',
    short_name: props.branch?.short_name || '',
    opening_date: props.branch?.opening_date || '',
    status: props.branch?.status || 'active',
    code: props.branch?.code || '',
    address: props.branch?.address || '',
    phone: props.branch?.phone || '',
    city: props.branch?.city || '',
    email: props.branch?.email || '',
    postal_code: props.branch?.postal_code || '',
    website: props.branch?.website || '',
    description: props.branch?.description || '',
    capacity: props.branch?.capacity || '',
    area: props.branch?.area || '',
})

function submit() {
    if (isEdit) {
        form.put(`/branches/${props.branch.id}`)
    } else {
        form.post('/branches')
    }
}
</script>

<template>
    <form @submit.prevent="submit">
        <!-- Card 1: Basic Info -->
        <Card class="mb-4">
            <template #title>Basic Information</template>
            <template #content>
                <div class="grid">
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Name *</label>
                        <InputText v-model="form.name" placeholder="Branch name" class="w-full" />
                        <p v-if="form.errors.name" style="color:red" class="mt-1">{{ form.errors.name }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Type</label>
                        <select v-model="form.type" class="w-full p-2 border-round">
                            <option value="main">Main</option>
                            <option value="additional">Additional</option>
                            <option value="partner">Partner</option>
                        </select>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Short Name</label>
                        <InputText v-model="form.short_name" placeholder="Short name" class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Opening Date</label>
                        <InputText type="date" v-model="form.opening_date" class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select v-model="form.status" class="w-full p-2 border-round">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Code</label>
                        <InputText v-model="form.code" placeholder="Auto-generated if empty" class="w-full" />
                    </div>
                </div>
            </template>
        </Card>

        <!-- Card 2: Address & Contacts -->
        <Card class="mb-4">
            <template #title>Address & Contacts</template>
            <template #content>
                <div class="grid">
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Address *</label>
                        <InputText v-model="form.address" placeholder="Full address" class="w-full" />
                        <p v-if="form.errors.address" style="color:red" class="mt-1">{{ form.errors.address }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Phone *</label>
                        <InputText v-model="form.phone" placeholder="Phone" class="w-full" />
                        <p v-if="form.errors.phone" style="color:red" class="mt-1">{{ form.errors.phone }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">City</label>
                        <InputText v-model="form.city" placeholder="City" class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Email</label>
                        <InputText v-model="form.email" placeholder="Email" class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Postal Code</label>
                        <InputText v-model="form.postal_code" placeholder="Postal code" class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Website</label>
                        <InputText v-model="form.website" placeholder="Website" class="w-full" />
                    </div>
                </div>
            </template>
        </Card>

        <!-- Card 3: Additional Info -->
        <Card class="mb-4">
            <template #title>Additional Information</template>
            <template #content>
                <div class="grid">
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Description</label>
                        <textarea v-model="form.description" rows="4" placeholder="Describe the branch"
                            class="w-full p-2 border-round"></textarea>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Capacity</label>
                        <InputText type="number" v-model="form.capacity" placeholder="Number of students"
                            class="w-full" />
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Area (m²)</label>
                        <InputText type="number" v-model="form.area" placeholder="Area in m²" class="w-full" />
                    </div>
                </div>
            </template>
        </Card>

        <!-- Actions -->
        <div class="flex justify-content-between">
            <Link :href="`/branches/${branch.id}`" class="p-button p-button-secondary no-underline">Cancel</Link>
            <Button type="submit" :disabled="form.processing">{{ isEdit ? 'Save Changes' : 'Create Branch' }}</Button>
        </div>
    </form>
</template>
