<template>
  <div class="my-4 flex flex-col gap-4">
    <!-- NOTE: GROUPS -->
    <BasicCard v-for="group in groups" :key="group.id" :title="group.name" :iconImg="group.avatar">
      <div class="flex gap-4">
        <!-- NOTE: TASK TEMPLATES (will open a prompt/modal when clicked) -->
        <button
          v-for="taskTemplate in group.task_templates"
          :key="taskTemplate.id"
          @click="createRequest(taskTemplate)"
          class="font-medium bg-white py-2 px-4 rounded-2xl shadow hover:shadow-md transition-all text-brand-700"
        >
          <div v-html="taskTemplate.task_priority.hero_icon.content" class="h-4 w-4 inline-block pt-[2px]"></div>
          {{ taskTemplate.name }}
        </button>
      </div>

    </BasicCard>
  </div>

  <!-- NOTE: REQUEST PROMPT/MODAL -->
  <FormModal
    :icon="PlusIcon"
    title="New Request"
    :description="`Requesting for...`"
    size="max-w-md"
    v-model="openRequestModal"
  >
    <div class="flex mb-4">
      <h2 class="font-medium bg-white px-4 py-2 shadow rounded-2xl">{{ form.task_template_name }}</h2>
    </div>

    <div class="mb-7">
      <AppSelect
        name="Task Priority"
        v-model="form.task_priority"
        :suggestions="task_priorities.map(row => {
          return {
            id: row.id,
            display_name: row.name,
          }
        })"
      />

        <AppTextArea v-model="form.message" name="Message (optional)" class="mt-4"/>
    </div>

    <div class="flex gap-2 justify-end">
      <AppButton @click="resetRequest()" :icon="XMarkIcon">Cancel</AppButton>
      <AppButton @click="submitRequest()" color="brand" :icon="PaperAirplaneIcon">Make a request</AppButton>
    </div>
  </FormModal>

</template>

<script setup lang="ts">
import { Group, TaskPriority, TaskTemplate } from '@/globalTypes'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

import { PlusIcon, XMarkIcon, PaperAirplaneIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'
import FormModal from '@/components/modals/FormModal.vue'
import AppButton from '@/components/form/AppButton.vue'
import AppSelect from '@/components/form/AppSelect.vue'
import AppTextArea from '@/components/form/AppTextArea.vue'

defineProps<{
  groups: Group []
  task_priorities: TaskPriority[]
}>()

const openRequestModal = ref(false)
const form = router.form({
  task_template_id: '',
  task_priority: {
    display_name: '',
    id: '',
  },
  task_template_name: '',
  message: '',
})

function createRequest(task_template: TaskTemplate) {
  form.task_template_id = task_template.id
  form.task_template_name = task_template.name
  form.task_priority = {
    display_name: task_template.task_priority.name,
    id: task_template.task_priority.id,
  }
  openRequestModal.value = true
}

function resetRequest() {
  form.reset()
  openRequestModal.value = false
}

async function submitRequest() {
  await router.post(route('index'), {
    task_template_id: form.task_template_id,
    task_priority_id: form.task_priority.id,
    message: form.message,
  })
  resetRequest()
}
</script>
