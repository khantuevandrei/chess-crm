<script setup>
import { useForm } from '@inertiajs/vue3'
import { InputText, Button, Card } from 'primevue'

const props = defineProps({
    lesson: { type: Object, default: null },
    trainers: { type: Array, required: true },
    students: { type: Array, required: true },
    branches: { type: Array, required: true },
})

const isEdit = !!props.lesson

const form = useForm({
    title: props.lesson?.title || '',
    trainer_id: props.lesson?.trainer_id || '',
    student_id: props.lesson?.student_id || '',
    branch_id: props.lesson?.branch_id || '',
    type: props.lesson?.type || 'individual',
    start_time: props.lesson?.start_time || '',
    end_time: props.lesson?.end_time || '',
    status: props.lesson?.status || 'scheduled',
    notes: props.lesson?.notes || '',
})

function submit() {
    if (isEdit) {
        form.put(`/lessons/${props.lesson.id}`)
    } else {
        form.post('/lessons')
    }
}

function goBack() {
    window.history.back()
}
</script>

<template>
    <form @submit.prevent="submit">
        <!-- Lesson Details Card -->
        <Card class="mb-4">
            <template #title>Lesson Details</template>
            <template #content>
                <div class="grid">
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Title *</label>
                        <InputText v-model="form.title" placeholder="Lesson title" class="w-full" />
                        <p v-if="form.errors.title" class="mt-1 text-red-500 text-sm">{{ form.errors.title }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Trainer *</label>
                        <select v-model="form.trainer_id" class="w-full p-2 border-round">
                            <option value="">Select Trainer</option>
                            <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                                {{ trainer.last_name }} {{ trainer.first_name }}
                            </option>
                        </select>
                        <p v-if="form.errors.trainer_id" class="mt-1 text-red-500 text-sm">{{ form.errors.trainer_id }}
                        </p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Student</label>
                        <select v-model="form.student_id" class="w-full p-2 border-round">
                            <option value="">No student (Group lesson)</option>
                            <option v-for="student in students" :key="student.id" :value="student.id">
                                {{ student.last_name }} {{ student.first_name }}
                            </option>
                        </select>
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
                        <label class="text-sm text-gray-600 mb-1 block">Type *</label>
                        <select v-model="form.type" class="w-full p-2 border-round">
                            <option value="individual">Individual</option>
                            <option value="group">Group</option>
                        </select>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Start Time *</label>
                        <InputText type="datetime-local" v-model="form.start_time" class="w-full" />
                        <p v-if="form.errors.start_time" class="mt-1 text-red-500 text-sm">{{ form.errors.start_time }}
                        </p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">End Time *</label>
                        <InputText type="datetime-local" v-model="form.end_time" class="w-full" />
                        <p v-if="form.errors.end_time" class="mt-1 text-red-500 text-sm">{{ form.errors.end_time }}</p>
                    </div>
                    <div class="col-12 md:col-6">
                        <label class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select v-model="form.status" class="w-full p-2 border-round">
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Notes Card -->
        <Card class="mb-4">
            <template #title>Notes</template>
            <template #content>
                <div class="grid">
                    <div class="col-12">
                        <label class="text-sm text-gray-600 mb-1 block">Notes</label>
                        <textarea v-model="form.notes" rows="3" placeholder="Lesson notes..."
                            class="w-full p-2 border-round"></textarea>
                        <p v-if="form.errors.notes" class="mt-1 text-red-500 text-sm">{{ form.errors.notes }}</p>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Action Buttons -->
        <div class="flex justify-content-between">
            <button type="button" @click="goBack" class="p-button p-button-secondary no-underline">← Back</button>
            <Button type="submit" :disabled="form.processing">
                {{ isEdit ? 'Save Changes' : 'Create Lesson' }}
            </Button>
        </div>
    </form>
</template>
