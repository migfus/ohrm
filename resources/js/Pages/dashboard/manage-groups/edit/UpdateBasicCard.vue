<template>
  <BasicCard
    :icon="AdjustmentsHorizontalIcon"
    title="Update Basic Information"
    description="Modify basic information of the group."
    :count="2"
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

    <AppToggle v-model="is_visible" name="Show to Public" @changed="putBasicAPI()"/>

  </BasicCard>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { defaultRouterState, errorAlert } from '@/converter'
import { onErrorCaptured, ref } from 'vue'

import { AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'
import AppToggleInput from '@/components/form/AppToggleInput.vue'
import AppToggleTextArea from '@/components/form/AppToggleTextArea.vue'
import AppToggle from '@/components/form/AppToggle.vue'

const $props = defineProps<{
  id: string
  is_visible: boolean
}>()

const $name = defineModel<string>('name')
const $description = defineModel<string>('description')
const default_name = $name.value ?? ''
const defaul_description = $description.value ?? ''
const is_visible = ref($props.is_visible)

const $emit = defineEmits(['submit'])

function putBasicAPI() {
  router.put(
    route('dashboard.manage-groups.update', { manage_group: $props.id }), {
      type: 'basic',
      name: $name.value,
      description: $description.value,
      is_visible: is_visible.value,
    },
    defaultRouterState(['group'])
  )
}

onErrorCaptured((e) => errorAlert('/dashboard/manage-groups/edit/UpdateBasicCard', e))
</script>
