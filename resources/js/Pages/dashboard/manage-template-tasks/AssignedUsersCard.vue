<template>
  <BasicCard :icon="UsersIcon" title="Give access to members" description="Update user's access to this template.">
    <AssignedUserDropdownMenu
      v-for="assigned in assignedUsers"
      :taskUserAccessId="assigned.id"
      :user="assigned.user"
      :key="assigned.id"
      @selected="UnassignUser"
    />

    <UsersComboBox :taskTemplateId :groupId @addMember="AssignMember" />
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { TTaskAccessUser, TUser } from '@/globalTypes'
import { UsersIcon } from '@heroicons/vue/24/solid'
import AssignedUserDropdownMenu from './AssignedUserDropdownMenu.vue'
import UsersComboBox from './UsersComboBox.vue'
import { router } from '@inertiajs/vue3'

const $props = defineProps<{
  assignedUsers: TTaskAccessUser[]
  groupId: string
  taskTemplateId: string
}>()

function AssignMember(user: TUser) {
  router.put(`/dashboard/manage-template-tasks/${$props.taskTemplateId}`, {
    userId: user.id,
    type: 'assign-user'
  }, {
    preserveScroll: true,
    preserveState: true
  })
}

function UnassignUser(value: { type: string, taskUserAccessId: string}) {
  router.put(`/dashboard/manage-template-tasks/${$props.taskTemplateId}`, {
    taskUserAccessId: value.taskUserAccessId,
    type: 'unassign-user'
  }, {
    preserveScroll: true,
    preserveState: true,
  })
}
</script>
