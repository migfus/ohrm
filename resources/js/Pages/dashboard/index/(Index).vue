<template>
  <div class="grid grid-cols-6 gap-4">

    <div class="col-span-6 lg:col-span-4 order-2 lg:order-1">
      <MyActivities :user_activities :current_count="processing_tasks.length"/>
    </div>
    <div class="col-span-6 lg:col-span-2 order-1 lg:order-2">
      <NavigationCard />
    </div>


    <div class="col-span-6 lg:col-span-3 xl:col-span-2 order-3">
      <QueuingTasks :queuing_tasks :task_status/>
    </div>
    <div class="col-span-6 lg:col-span-3 xl:col-span-2 order-4">
      <ProcessingTask :processing_tasks :task_status/>
    </div>
    <div class="col-span-6 lg:col-span-6 xl:col-span-2 order-5">
      <CompletedTask :completed_tasks :task_status/>
    </div>
  </div>

</template>

<script setup lang="ts">
import { Task, TaskStatus } from '@/globalTypes'
import moment from 'moment'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import QueuingTasks from './QueuingTasks.vue'
import ProcessingTask from './ProcessingTask.vue'
import CompletedTask from './CompletedTask.vue'
import MyActivities from './MyActivities.vue'
import NavigationCard from './NavigationCard.vue'

const $props = defineProps<{
  queuing_tasks: Task[]
  processing_tasks: Task[]
  completed_tasks: Task[]
  user_activities: {
    date: string
    count: number
  }[]
  task_status: TaskStatus[]
}>()

const user_activities = [
  {
    date: moment().format('YYYY-MM-DD'),
    count: $props.processing_tasks.length
  },
  ...$props.user_activities
]

onErrorCaptured((e) => errorAlert('/dashboard/index/(Index)', e))
</script>
