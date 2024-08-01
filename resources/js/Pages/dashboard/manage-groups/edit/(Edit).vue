<template>
  <div ref="infinite">
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      v-model:name="form.name"
      :admins="group_members.filter((member: GroupMember) =>
        member.group_role_id == group_roles.filter((role: GroupRole) => role.display_name == 'Administrator')[0].id
      )"
      :confirmButton="{
        text: 'Delete',
        icon: XMarkIcon,
        color: 'danger'
      }"
      @uploadAvatar="uploadAvatarAPI"
      @uploadCover="uploadCoverAPI"
    />
    <FlashErrors :errors="$page.props.errors"/>

    <div class="flex gap-2 mt-4 justify-center sm:justify-between flex-wrap w-full">
      <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto sm:order-2 mx-4 sm:mx-0">
        <AppButton :icon="ArrowsRightLeftIcon" :href="route('dashboard.manage-groups.index')">Group Lists</AppButton>
        <AppButton :icon="XMarkIcon" color="danger" @click="removeGroupAPI()">Remove</AppButton>
      </div>

      <div class="flex justify-end">
        <div class="flex space-x-1 rounded-2xl bg-brand-50 p-0.5 mx-auto" role="tablist" aria-orientation="horizontal">
          <AppButton
            :icon="TicketIcon"
            size="sm"
            :color="!is_community ? 'white' : 'transparent'"
            @click="is_community = !is_community"
          >
            Tasks View
          </AppButton>
          <AppButton
            :icon="PaperAirplaneIcon"
            size="sm"
            :color="is_community ? 'white' : 'transparent'"
            @click="is_community = !is_community"
          >
            Community View
          </AppButton>
        </div>
      </div>

    </div>

    <div class="grid grid-cols-4 gap-4 mt-4">
      <div class="col-span-4 lg:col-span-1 space-y-4 order-1">
        <UpateBasicCard
          v-model:name="form.name"
          v-model:description="form.description"
          :id="group.id"
        />

        <PinnedPostsCard :groupId="group.id"/>

      </div>

      <div class="col-span-4 lg:col-span-2 space-y-4 order-3">
        <GroupHeatMapCard
          :group_task_activities
          :now_task_activities="tasks.length"
        />
        <UpdateTemplateTasksCard
          v-if="!is_community"
          :taskTemplates="task_templates"
          :groupId="group.id"
          :taskPriorities="task_priorities"
        />
        <RecentTasksCard
          v-if="!is_community"
          :tasks="tasks"
          :taskTemplates="task_templates"
        />
        <PostSection v-if="is_community" :groupId="group.id"/>
      </div>

      <div class="col-span-4 lg:col-span-1 space-y-4 order-2 lg:order-3">
        <UpdateMembersCard
          v-for="groupRole in group_roles"
          :key="groupRole.id"
          :groupRole
          :groupId="group.id"
          :groupMembers="group_members"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { Group, GroupRole, TaskPriority, GroupMember, TaskTemplate, Task } from '@/globalTypes'
import { defaultRouterState } from '@/converter'
import { ref } from 'vue'

import GroupHeader from '.././GroupHeader.vue'
import GroupHeatMapCard from './GroupHeatMapCard.vue'
import UpateBasicCard from './UpdateBasicCard.vue'
import UpdateMembersCard from './UpdateMembersCard.vue'
import FlashErrors from '@/components/headers/FlashErrors.vue'
import { ArrowsRightLeftIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import UpdateTemplateTasksCard from './UpdateTemplateTasksCard.vue'
import PinnedPostsCard from './pinned-posts/PinnedPostsCard.vue'
import RecentTasksCard from './RecentTasksCard.vue'
import PostSection from './posts/PostSection.vue'
import AppButton from '@/components/form/AppButton.vue'
import { PaperAirplaneIcon, TicketIcon } from '@heroicons/vue/24/solid'

const $props = defineProps<{
  group: Group
  group_roles: GroupRole[]
  group_members: GroupMember[]
  task_templates: TaskTemplate[]
  tasks: Task[]
  task_priorities: TaskPriority[]
  group_task_activities: {
    date: string
    count: number
  }[]
}>()

const form = router.form({
  name: $props.group.name,
  description: $props.group.description,
  avatar: $props.group.avatar,
  cover: $props.group.cover,
})
const is_community = ref<boolean>(false)

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
