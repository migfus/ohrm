<template>
  <div class="grid grid-cols-2 gap-4">
    <div class="flex flex-col gap-4 col-span-2 lg:col-span-1">
      <MyActivities :user_activities :current_count="marked_tasks.length"/>
      <PendingTasks :pending_tasks :task_status/>
    </div>
    <div class="col-span-2 lg:col-span-1">
      <MarkedTasks :marked_tasks />
    </div>
  </div>

</template>

<script setup lang="ts">
import { Task, TaskStatus } from '@/globalTypes'
import moment from 'moment'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import PendingTasks from './PendingTasks.vue'
import MarkedTasks from './MarkedTasks.vue'
import MyActivities from './MyActivities.vue'

const $props = defineProps<{
  pending_tasks: Task[]
  marked_tasks: Task[]
  user_activities: {
    date: string
    count: number
  }[]
  task_status: TaskStatus[]
}>()

const user_activities = [
  {
    date: moment().format('YYYY-MM-DD'),
    count: $props.marked_tasks.length
  },
  ...$props.user_activities
]

onErrorCaptured((e) => errorAlert('/dashboard/index/(Index)', e))
</script>
