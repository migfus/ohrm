<template>
  <div class="grid grid-cols-6 gap-4">
    <InfoCard
      :id="taskTemplate.id"
      :name="taskTemplate.name"
      :description="taskTemplate.description ?? ''"
      :group="taskTemplate.group"
      class="col-span-6 lg:col-span-3"
    />
    <AssignedUsersCard
      :assignedUsers
      :groupId="taskTemplate.group_id"
      :taskTemplateId="taskTemplate.id"
      class="col-span-6 lg:col-span-3"
    />
    <TasksCard :name="taskTemplate.name" :tasks class="col-span-6"/>
  </div>
</template>

<script setup lang="ts">
import { TTaskAssignedUser, TTaskTemplate, TTask } from '@/globalTypes'
import InfoCard from './InfoCard.vue'
import AssignedUsersCard from './AssignedUsersCard.vue'
import TasksCard from './TasksCard.vue'

defineProps<{
  taskTemplate: TTaskTemplate
  assignedUsers: TTaskAssignedUser[]
  tasks: TTask[]
}>()
</script>
