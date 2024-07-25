<template>
  <BasicCard :icon="UsersIcon" title="Member's Access" description="Gives access to the members">
    <DataTransition>
      <AssignedUserDropdownMenu
        v-for="access in taskUserAccess"
        :key="access.id"
        :taskUserAccessId="access.id"
        :user="access.user"
        @selected="unassignUser"
      />
    </DataTransition>

    <UsersComboBox :taskTemplateId :groupId @addMember="assignMember" />
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { TaskAccessUser, User } from '@/globalTypes'
import { UsersIcon } from '@heroicons/vue/24/solid'
import AssignedUserDropdownMenu from './AssignedUserDropdownMenu.vue'
import UsersComboBox from './UsersComboBox.vue'
import { router } from '@inertiajs/vue3'
import DataTransition from '@/components/transitions/DataTransition.vue'

const $props = defineProps<{
  taskUserAccess: TaskAccessUser[]
  groupId: string
  taskTemplateId: string
}>()

function assignMember(user: User) {
  router.put(route('dashboard.manage-template-tasks.update', { manage_template_task: $props.taskTemplateId }), {
    user_id: user.id,
    type: 'assign-user'
  }, {
    preserveScroll: true,
    preserveState: true
  })
}

function unassignUser(type: string, task_user_access_id: string) {
  router.put(route('dashboard.manage-template-tasks.update', { manage_template_task: $props.taskTemplateId }), {
    task_user_access_id: task_user_access_id,
    type: 'unassign-user'
  }, {
    preserveScroll: true,
    preserveState: true,
  })
}
</script>
