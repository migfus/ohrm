<template>
  <div class="grid grid-cols-6 gap-4">
    <InfoCard
      :id="task_template.id"
      :taskTemplate = 'task_template'
      :group="task_template.group"
      class="col-span-6 lg:col-span-3"
    />
    <AssignedUsersCard
      :taskUserAccess = 'task_user_access'
      :groupId="task_template.group_id"
      :taskTemplateId="task_template.id"
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
  task_template: TaskTemplate
  task_user_access: TaskAccessUser[]
  tasks: Task[]
}>()
</script>
