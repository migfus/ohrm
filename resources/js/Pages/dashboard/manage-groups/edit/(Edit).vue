<template>
  <div>
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      v-model:name="form.name"
      :heads="data.heads"
      :confirmButton="{
        text: 'Delete',
        icon: XMarkIcon,
        color: 'danger'
      }"
      @remove="removeGroup"
    />
    <FlashErrors :errors="$page.props.errors"/>

    <div class="grid grid-cols-4 gap-4 mt-4">
      <div class="col-span-4 lg:col-span-1">
        <UpateBasicCard
          v-model:name="form.name"
          v-model:description="form.description"
          :id="data.id"
        />
        <UpdateTasksCard :tasks="data.tasks" :id="data.id"/>

      </div>
      <div class="col-span-4 lg:col-span-2">
        <GroupHeatMapCard />
      </div>
      <div class="col-span-4 lg:col-span-1">
        <UpdateHeadsCard :users="data.heads"/>
        <MembersCard :users :members="data.members" :id="data.id"/>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { TTeam, TUser } from '@/globalTypes'

import GroupHeader from '.././GroupHeader.vue'
import GroupHeatMapCard from './GroupHeatMapCard.vue'
import UpateBasicCard from './UpdateBasicCard.vue'
import MembersCard from './MembersCard.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'
import { XMarkIcon } from '@heroicons/vue/20/solid'
import UpdateTasksCard from './UpdateTasksCard.vue'
import UpdateHeadsCard from './UpdateHeadsCard.vue'

const $props = defineProps<{
  data: TTeam
  users: TUser[]
}>()

const form = router.form({
  name: $props.data.display_name,
  description: $props.data.description,
  avatar: $props.data.avatar,
  cover: $props.data.cover,
  heads: $props.data.heads
})

function removeGroup() {
  router.delete(`/dashboard/manage-groups/${$props.data.id}`)
}


</script>
