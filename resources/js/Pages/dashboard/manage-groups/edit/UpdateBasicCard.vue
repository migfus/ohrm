<template>
  <BasicCard
    :icon="AdjustmentsHorizontalIcon"
    title="Update Basic Information"
    description="Modify basic information of the group."
  >
    <AppToggleInput
      name="Name"
      :defaultValue="default_name"
      v-model="$name"
      @submit="putBasicAPI()"

    />

    <AppToggleTextArea
      name="Description"
      :defaultValue="defaul_description"
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
const default_name = $name.value ?? ''
const defaul_description = $description.value ?? ''

const $props = defineProps<{
  id: string
}>()
const $emit = defineEmits(['submit'])

function putBasicAPI() {
  router.put(
    route('dashboard.manage-groups.update', { manage_group: $props.id }), {
      type: 'basic',
      name: $name.value,
      description: $description.value,
    },
    defaultRouterState(['group'])
  )
}
</script>
