<template>
  <div>
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      v-model:name="form.name"
      :admins="data.group_members.filter( member =>
        member.group_role_id == group_roles.filter(role =>
          role.display_name == 'Administrator')[0].id
        )"
      :confirmButton="{
        text: 'Delete',
        icon: XMarkIcon,
        color: 'danger'
      }"
      @confirm="remove()"
      @uploadAvatar="uploadAvatar"
      @uploadCover="uploadCover"
    />
    <FlashErrors :errors="$page.props.errors"/>

    <div class="grid grid-cols-4 gap-4 mt-4">
      <div class="col-span-4 lg:col-span-1 space-y-4">
        <UpateBasicCard
          v-model:name="form.name"
          v-model:description="form.description"
          :id="data.id"
        />
        <PinnedPostsCard />

      </div>
      <div class="col-span-4 lg:col-span-2 space-y-4">
        <GroupHeatMapCard />
        <UpdateTasksCard :tasks="data.task_templates" :id="data.id"/>
      </div>
      <div class="col-span-4 lg:col-span-1 space-y-4">
        <UpdateMembersCard
          v-for="role in group_roles"
          :key="role.id"
          :roleId="role.id"
          :groupId="data.id"
          :icon="role.hero_icon.content"
          :name="`${role.display_name}s`"
          :description="role.description"
          :members="data.group_members"
        />
      </div>
    </div>

    <RemovalPrompt v-model="openPrompt" title="Deletion Group" confirmMessage="Yes, Delete Group!" @confirm="removeGroup">
      Do you want to remove this group? This action cannot be undone.
    </RemovalPrompt>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { TGroup, TGroupRole } from '@/globalTypes'

import GroupHeader from '.././GroupHeader.vue'
import GroupHeatMapCard from './GroupHeatMapCard.vue'
import UpateBasicCard from './UpdateBasicCard.vue'
import UpdateMembersCard from './UpdateMembersCard.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'
import { XMarkIcon } from '@heroicons/vue/20/solid'
import UpdateTasksCard from './UpdateTasksCard.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import PinnedPostsCard from './PinnedPostsCard.vue'

const $props = defineProps<{
  data: TGroup
  group_roles: TGroupRole []
}>()

const form = router.form({
  name: $props.data.name,
  description: $props.data.description,
  avatar: $props.data.avatar,
  cover: $props.data.cover,
})

const openPrompt = ref<boolean>(false)

// ✅
function remove() {
  openPrompt.value = true
}
// ✅
function removeGroup() {
  router.delete(`/dashboard/manage-groups/${$props.data.id}`)
}
// ✅
function uploadAvatar(value: string) {
  router.put(`/dashboard/manage-groups/${$props.data.id}`, {avatar: value, type: 'avatar'})
}
// ✅
function uploadCover(value: string) {
  router.put(`/dashboard/manage-groups/${$props.data.id}`, {cover: value, type: 'cover'})
}
</script>
