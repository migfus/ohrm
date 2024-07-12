<template>
  <BasicCard :icon="UsersIcon" title="Member's Access" description="Gives access to the members">
    <DataTransition>
      <AssignedUserDropdownMenu
        v-for="access in taskUserAccess"
        :key="access.id"
        :taskUserAccessId="access.id"
        :user="access.user"
        @selected="UnassignUser"
      />
    </DataTransition>

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
import DataTransition from '@/components/transitions/DataTransition.vue'

const $props = defineProps<{
  taskUserAccess: TTaskAccessUser[]
  groupId: string
  taskTemplateId: string
}>()

function AssignMember(user: TUser) {
  router.put(route('dashboard.manage-template-tasks.update', { manage_template_task: $props.taskTemplateId }), {
    userId: user.id,
    type: 'assign-user'
  }, {
    preserveScroll: true,
    preserveState: true
  })
}

function UnassignUser(value: { type: string, taskUserAccessId: string}) {
  router.put(route('dashboard.manage-template-tasks.update', { manage_template_task: $props.taskTemplateId }), {
    taskUserAccessId: value.taskUserAccessId,
    type: 'unassign-user'
  }, {
    preserveScroll: true,
    preserveState: true,
  })
}
</script>
