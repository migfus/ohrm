<template>
  <BasicCard
    :icon="TicketIcon"
    title="Basic Info"
    description="Update basic info of the template task"
  >
    <Link :href="`/dashboard/manage-groups/${group.id}/edit`"  class="flex justify-between bg-white px-4 py-3 rounded-2xl shadow hover:shadow-md mb-4 transition-all">
      <div class="flex-grow truncate">
        <img :src="group.avatar" class="h-4 w-4 inline mr-2 rounded mb-[2px]"/>
        <span class="font-medium">{{ group.name }}</span>
      </div>
      <ArrowLeftIcon class="w-5 h-5 mt-[4px]"/>
    </Link>

    <AppToggleInput v-model="form.name" name="Name" :defaultValue="name" @submit="update()"/>
    <AppToggleTextArea v-model="form.description" name="Description" :defaultValue="description" @submit="update()"/>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon, ArrowLeftIcon } from '@heroicons/vue/24/solid'
import AppToggleInput from '@/components/form/AppToggleInput.vue'
import AppToggleTextArea from '@/components/form/AppToggleTextArea.vue'
import { router } from '@inertiajs/vue3'
import { TGroup } from '@/globalTypes'

const $props = defineProps<{
  name: string
  description: string
  id: string
  group: TGroup
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
