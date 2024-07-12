<template>
  <div ref="infinite">
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      v-model:name="form.name"
      :admins="groupMembers.filter(member =>
        member.group_role_id == groupRoles.filter(role => role.display_name == 'Administrator')[0].id
      )"
      :confirmButton="{
        text: 'Delete',
        icon: XMarkIcon,
        color: 'danger'
      }"
      @removeGroup="removeGroupAPI()"
      @uploadAvatar="uploadAvatarAPI"
      @uploadCover="uploadCoverAPI"
    />
    <FlashErrors :errors="$page.props.errors"/>

    <div class="grid grid-cols-4 gap-4 mt-4">
      <div class="col-span-4 lg:col-span-1 space-y-4">
        <UpateBasicCard
          v-model:name="form.name"
          v-model:description="form.description"
          :id="group.id"
        />
        <PinnedPostsCard :posts="pinnedPosts" :groupId="group.id" />
      </div>

      <div class="col-span-4 lg:col-span-2 space-y-4">
        <GroupHeatMapCard />
        <UpdateTemplateTasksCard :taskTemplates :groupId="group.id" :taskPriorities/>
        <RecentTasksCard :tasks="tasks" :taskTemplates/>
        <PostSection :groupId="group.id"/>
      </div>

      <div class="col-span-4 lg:col-span-1 space-y-4">
        <UpdateMembersCard
          v-for="groupRole in groupRoles"
          :key="groupRole.id"
          :groupRole
          :groupId="group.id"
          :groupMembers
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { TGroup, TGroupRole, TTaskPriority, TPost, TGroupMember, TTaskTemplate, TTask, TPagination } from '@/globalTypes'
import { defaultRouterState } from '@/converter'

import GroupHeader from '.././GroupHeader.vue'
import GroupHeatMapCard from './GroupHeatMapCard.vue'
import UpateBasicCard from './UpdateBasicCard.vue'
import UpdateMembersCard from './UpdateMembersCard.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'
import { XMarkIcon } from '@heroicons/vue/20/solid'
import UpdateTemplateTasksCard from './UpdateTemplateTasksCard.vue'
import PinnedPostsCard from './PinnedPostsCard.vue'
import RecentTasksCard from './RecentTasksCard.vue'
import PostSection from './PostSection.vue'

const $props = defineProps<{
  group: TGroup
  groupRoles: TGroupRole[]
  groupMembers: TGroupMember[]
  taskTemplates: TTaskTemplate[]
  tasks: TTask[]
  taskPriorities: TTaskPriority[]
  pinnedPosts: TPost[]
}>()

const form = router.form({
  name: $props.group.name,
  description: $props.group.description,
  avatar: $props.group.avatar,
  cover: $props.group.cover,
})

// ✅
function removeGroupAPI() {
  router.delete(route('dashboard.manage-groups.destroy', { manage_group: $props.group.id }))
  // redirect to group list
}
// ✅
function uploadAvatarAPI(value: string) {
  router.put(
    route('dashboard.manage-groups.update', { manage_group: $props.group.id }), {
      avatar: value,
      type: 'avatar'
    },
    defaultRouterState(['group'])
  )
}
// ✅
function uploadCoverAPI(value: string) {
  router.put(
    route('dashboard.manage-groups.update', { manage_group: $props.group.id }), {
      cover: value,
      type: 'cover'
    },
    defaultRouterState(['group'])
  )
}
</script>
