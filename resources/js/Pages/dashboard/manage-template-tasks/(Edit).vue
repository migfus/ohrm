<template>
  <div class="grid grid-cols-6 gap-4">
    <InfoCard
      :id="taskTemplate.id"
      :taskTemplate
      :group="taskTemplate.group"
      class="col-span-6 lg:col-span-3"
    />
    <AssignedUsersCard
      :taskUserAccess
      :groupId="taskTemplate.group_id"
      :taskTemplateId="taskTemplate.id"
      class="col-span-6 lg:col-span-3"
    />
    <TasksCard :tasks class="col-span-6"/>
  </div>
</template>

<script setup lang="ts">
import { TaskAccessUser, TaskTemplate, Task } from '@/globalTypes'
import InfoCard from './InfoCard.vue'
import AssignedUsersCard from './AssignedUsersCard.vue'
import TasksCard from './TasksCard.vue'

defineProps<{
  taskTemplate: TaskTemplate
  taskUserAccess: TaskAccessUser[]
  tasks: Task[]
}>()
</script>
