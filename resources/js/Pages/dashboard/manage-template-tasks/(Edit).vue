<template>
  <div class="grid grid-cols-6 gap-4">
    <GroupInfoCard :groupId="taskTemplate.group_id" :name="taskTemplate.group.name" :avatar="taskTemplate.group.avatar" class="col-span-6 lg:col-span-6 xl:col-span-2"/>
    <InfoCard
      :id="taskTemplate.id"
      :name="taskTemplate.name"
      :description="taskTemplate.description ?? ''"
      class="col-span-6 lg:col-span-3 xl:col-span-2"
    />
    <AssignedUsersCard
      :assignedUsers
      :groupId="taskTemplate.group_id"
      :taskTemplateId="taskTemplate.id"
      class="col-span-6 lg:col-span-3 xl:col-span-2"
    />
    <TasksCard :name="taskTemplate.name" class="col-span-6"/>
  </div>
</template>

<script setup lang="ts">
import { TTaskAssignedUser, TTaskTemplate } from '@/globalTypes'
import InfoCard from './InfoCard.vue'
import AssignedUsersCard from './AssignedUsersCard.vue'
import GroupInfoCard from './GroupInfoCard.vue'
import TasksCard from './TasksCard.vue'

defineProps<{
  taskTemplate: TTaskTemplate
  assignedUsers: TTaskAssignedUser[]
}>()
</script>
