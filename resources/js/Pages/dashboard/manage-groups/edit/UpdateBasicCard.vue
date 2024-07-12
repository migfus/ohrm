<template>
  <BasicCard
    :icon="AdjustmentsHorizontalIcon"
    title="Update Basic Information"
    description="Modify basic information of the group."
  >
    <AppToggleInput
      name="Name"
      :defaultValue="defaultName"
      v-model="$name"
      @submit="putBasicAPI()"

    />

    <AppToggleTextArea
      name="Description"
      :defaultValue="defaulDescription"
      v-model="$description"
      @submit="putBasicAPI()"
    />
  </BasicCard>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { defaultRouterState } from '@/converter'

import { AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'
import AppToggleInput from '@/components/form/AppToggleInput.vue'
import AppToggleTextArea from '@/components/form/AppToggleTextArea.vue'

const $name = defineModel<string>('name')
const $description = defineModel<string>('description')
const defaultName = $name.value ?? ''
const defaulDescription = $description.value ?? ''

const $props = defineProps<{
  id: string
}>()
const $emit = defineEmits(['submit'])

function putBasicAPI() {
  router.put(
    `/dashboard/manage-groups/${$props.id}`, {
      type: 'basic',
      name: $name.value,
      description: $description.value,
    },
    defaultRouterState(['group'])
  )
}
</script>
