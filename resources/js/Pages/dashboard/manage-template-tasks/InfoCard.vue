<template>
  <BasicCard
    :icon="TicketIcon"
    title="Basic Info"
    description="Update basic info of the template task"
  >
    <AppToggleInput v-model="form.name" name="Name" :defaultValue="name" @submit="update()"/>
    <AppToggleTextArea v-model="form.description" name="Description" :defaultValue="description" @submit="update()"/>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon } from '@heroicons/vue/24/solid'
import AppToggleInput from '@/components/form/AppToggleInput.vue'
import AppToggleTextArea from '@/components/form/AppToggleTextArea.vue'
import { router } from '@inertiajs/vue3'

const $props = defineProps<{
  name: string
  description: string
  id: string
}>()

const form = router.form({
  name: $props.name,
  description: $props.description,
})

function update() {
  router.put(`/dashboard/manage-template-tasks/${$props.id}`, {
    type: 'basic',
    name: form.name,
    description: form.description,
  }, {
    preserveScroll: true,
    preserveState: true
  })
}
</script>
