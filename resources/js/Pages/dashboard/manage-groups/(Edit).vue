<template>
  <div>
    <GroupHeader v-model:avatar="form.avatar" v-model:cover="form.cover" :form :head="data.head[0]" @remove="removeGroup"/>
    <FlashErrors :errors="$page.props.errors"/>

    <div class="grid grid-cols-4 gap-4 mt-4">
      <div class="col-span-4 lg:col-span-1">
        <AboutCard :group="data"/>
        <OwnerCard :user="data.head[0]" class="mt-4"/>
      </div>
      <div class="col-span-4 lg:col-span-2">
        <GroupHeatMapCard />
      </div>
      <div class="col-span-4 lg:col-span-1">
        <TasksCard :users="data.members" />
        <MembersCard :users="data.members" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { TTeam } from '@/globalTypes'

import GroupHeader from './GroupHeader.vue'
import GroupHeatMapCard from './GroupHeatMapCard.vue'
import AboutCard from './AboutCard.vue'
import OwnerCard from './OwnerCard.vue'
import MembersCard from './MembersCard.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'
import TasksCard from './TasksCard.vue'

const $props = defineProps<{
  data: TTeam
}>()

const form = router.form({
  name: $props.data.display_name,
  description: $props.data.description,
  avatar: $props.data.avatar,
  cover: $props.data.cover,
  head: $props.data.head
})

function removeGroup() {
  router.delete(`/dashboard/manage-groups/${$props.data.id}`)
}
</script>
