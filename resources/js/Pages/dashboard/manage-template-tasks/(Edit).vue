<template>
  <div class="grid grid-cols-3 gap-4">
    <div class="col-span-3 lg:col-span-2 gap-4 flex flex-col order-2 lg:order-1">
      <div class="grid lg:grid-cols-2 gap-4">
        <NavigateCard :group="task_template.group"/>

        <InfoCard
          :id="task_template.id"
          :taskTemplate = 'task_template'
          :group="task_template.group"
          class=""
        />
      </div>

      <div class="grid lg:grid-cols-2 bg-brand-50 px-4 py-4 rounded-2xl shadow">
        <TaskCard :task v-for="task in tasks" class=""/>
      </div>
    </div>


    <AssignedUsersCard
      :taskUserAccess = 'task_user_access'
      :groupId="task_template.group_id"
      :taskTemplateId="task_template.id"
      class="col-span-3 lg:col-span-1 order-1"
    />

  </div>
</template>

<script setup lang="ts">
import { TaskAccessUser, TaskTemplate, Task } from '@/globalTypes'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import InfoCard from './InfoCard.vue'
import AssignedUsersCard from './AssignedUsersCard.vue'
import TaskCard from './TaskCard.vue'
import NavigateCard from './NavigateCard.vue'

defineProps<{
  task_template: TaskTemplate
  task_user_access: TaskAccessUser[]
  tasks: Task[]
}>()

onErrorCaptured((e) => errorAlert('/dashboard/manage-template-tasks/(Edit)', e))
</script>
