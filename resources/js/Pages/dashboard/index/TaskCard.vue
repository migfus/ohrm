<template>
  <div class="bg-white p-4 shadow rounded-2xl font-medium">
    <div class="flex justify-between">
      <div class="flex">
        <div class="text-xs text-brand-600 mt-1 mr-1 truncate">{{ taskIdSplitter(task.id, 'date_time')}} - </div>
        <div class="text-bran-900">#{{ taskIdSplitter(task.id, 'incremental')}}</div>
      </div>
      <div class="text-sm text-brand-400">
        <TaskDropdown
          :task_id="task.id"
          :task_status
          :index
          :current_task_status="task.task_status"
          @selectedStatus="(status_id, task_id) => $emit('selectedStatus', status_id, task_id)"
        />
      </div>
    </div>

    <div class="flex justify-between">
      <div class="flex">
        {{ task.name }}
      </div>
      <div class="text-sm text-brand-400">
        <label>{{  dateTimeFormatted(task.created_at) }}</label>
      </div>
    </div>

    <div class="flex justify-between mt-1">
      <div class="flex text-sm font-normal w-[75%]">
        <img :src="task.task_template?.group.avatar" class="inline h-3 w-3 mr-2 rounded-sm mt-1"/>
        <label class="truncate">{{ task.task_template?.group.name }}</label>
      </div>
      <div class="text-sm text-brand-400" :style="`color: #${task.task_priority.color}`">
        <div v-html="task.task_priority.hero_icon.content" class="h-4 w-4 inline-block -mb-1 mr-1"></div>
        <label>{{  task.task_priority.name  }}</label>
      </div>
    </div>

    <div class="flex justify-end mt-1">
      <div v-if="task.user_assigned" class="text-sm text-brand-400">
        <img :src="task.user_assigned?.avatar" class="h-4 w-4 rounded-full inline-block mr-1" />
        <label>{{  task.user_assigned?.name  }}</label>
      </div>
      <div v-else class="text-sm text-brand-400">
        <QuestionMarkCircleIcon class="h-4 w-4 rounded-full inline-block mr-1" />
        <label>Unassigned</label>
      </div>
    </div>

    <div class="flex justify-between mt-1 bg-brand-50 rounded-2xl shadow py-2 px-4">
      <div class="flex text-sm ">
        {{ task.message }}
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Task, TaskStatus } from '@/globalTypes'
import { dateTimeFormatted, taskIdSplitter } from '@/converter'

import TaskDropdown from './TaskDropdown.vue'
import { QuestionMarkCircleIcon } from '@heroicons/vue/20/solid'

defineProps<{
  task: Task
  index: number
  task_status: TaskStatus[]
}>()

const $emit = defineEmits(['selectedStatus'])
</script>
