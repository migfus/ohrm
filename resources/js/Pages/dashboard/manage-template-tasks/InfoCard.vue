<template>
  <BasicCard
    :icon="TicketIcon"
    title="Basic Info"
    description="Update basic info of the template task"
    :count="3"
  >
    <AppToggleInput v-model="form.name" name="Name" :defaultValue="taskTemplate.name" @submit="update()"/>
    <AppToggleTextArea v-model="form.message" name="Message" :defaultValue="taskTemplate.message ?? ''" @submit="update()" noLabel/>
    <AppToggle v-model="form.show" :name="isShowToggleName" @changed="update()"/>
  </BasicCard>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { Group, TaskTemplate } from '@/globalTypes'
import { computed } from 'vue'
import { errorAlert } from '@/converter'
import { onErrorCaptured } from 'vue'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon, ArrowLeftIcon } from '@heroicons/vue/24/solid'
import AppToggleInput from '@/components/form/AppToggleInput.vue'
import AppToggleTextArea from '@/components/form/AppToggleTextArea.vue'
import AppToggle from '@/components/form/AppToggle.vue'

const $props = defineProps<{
  taskTemplate: TaskTemplate
  group: Group
}>()

const isShowToggleName = computed(() => form.show ? 'Visible to requesting page' : 'Hidden')

const form = router.form({
  name: $props.taskTemplate.name,
  message: $props.taskTemplate.message,
  show: $props.taskTemplate.is_show ? true : false,
})

function update() {
  router.put(route('dashboard.manage-template-tasks.update', { manage_template_task: $props.taskTemplate.id }), {
    type: 'basic',
    name: form.name,
    message: form.message,
    show: form.show,
  }, {
    preserveScroll: true,
    preserveState: true
  })
}

onErrorCaptured((e) => errorAlert('/dashboard/manage-template-tasks/InfoCard', e))
</script>
