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
      <ArrowLeftIcon class="w-5 h-5 mt-[2px]"/>
    </Link>

    <AppToggleInput v-model="form.name" name="Name" :defaultValue="taskTemplate.name" @submit="update()"/>
    <AppToggleTextArea v-model="form.description" name="Description" :defaultValue="taskTemplate.description ?? ''" @submit="update()" noLabel/>
    <AppToggle v-model="form.show" :name="isShowToggleName" @changed="update()"/>
  </BasicCard>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { TGroup, TTaskTemplate } from '@/globalTypes'
import { computed } from 'vue'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon, ArrowLeftIcon } from '@heroicons/vue/24/solid'
import AppToggleInput from '@/components/form/AppToggleInput.vue'
import AppToggleTextArea from '@/components/form/AppToggleTextArea.vue'
import AppToggle from '@/components/form/AppToggle.vue'

const $props = defineProps<{
  taskTemplate: TTaskTemplate
  group: TGroup
}>()

const isShowToggleName = computed(() => form.show ? 'Visible to requesting page' : 'Hidden')

const form = router.form({
  name: $props.taskTemplate.name,
  description: $props.taskTemplate.description,
  show: $props.taskTemplate.is_show ? true : false,
})

function update() {
  router.put(`/dashboard/manage-template-tasks/${$props.taskTemplate.id}`, {
    type: 'basic',
    name: form.name,
    description: form.description,
    show: form.show,
  }, {
    preserveScroll: true,
    preserveState: true
  })
}
</script>
