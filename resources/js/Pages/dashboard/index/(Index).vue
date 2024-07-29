<template>
  <div class="grid grid-cols-2 gap-4">
    <div class="flex flex-col gap-4 col-span-2 lg:col-span-1">
      <MyActivities :user_activities />
      <PendingTasks :pending_tasks />
    </div>
    <div class="col-span-2 lg:col-span-1">
      <ProcessedTasks :task_processed />
    </div>
  </div>

</template>

<script setup lang="ts">
import { Task } from '@/globalTypes'

import PendingTasks from './PendingTasks.vue'
import ProcessedTasks from './ProcessedTasks.vue'
import MyActivities from './MyActivities.vue'
import moment from 'moment'

const $props = defineProps<{
  pending_tasks: Task[]
  task_processed: Task[]
  user_activities: {
    date: string
    count: number
  }[]
}>()

const user_activities = [
  {
    date: moment().format('YYYY-MM-DD'),
    count: $props.task_processed.length
  },
  ...$props.user_activities
]
</script>
