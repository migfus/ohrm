<template>
  <div>
    <BasicCard :icon="TicketIcon" title="Pending Tasks" description="Task Assigned">
      <div class="flex flex-col gap-2">
        <div v-for="task, index in pending_tasks" :key="task.id" class="bg-white p-4 shadow rounded-2xl font-medium">
          <div class="flex justify-between">
            <div class="flex">
              <div class="text-xs text-brand-600 mt-1 mr-1">{{ taskIdSplitter(task.id, 'date_time')}}</div>
              <div class="text-bran-900"> - #{{ taskIdSplitter(task.id, 'incremental')}}</div>
            </div>
            <div class="text-sm text-brand-400">
              <TaskDropdown :task_id="task.id" :index/>
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

          <div class="flex justify-between mt-1 bg-brand-50 rounded-2xl shadow py-2 px-4">
            <div class="flex text-sm ">
              {{ task.message }}
            </div>
          </div>
        </div>
      </div>
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { Task } from '@/globalTypes'
import { dateTimeFormatted, taskIdSplitter } from '@/converter'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon } from '@heroicons/vue/24/solid'

import TaskDropdown from './TaskDropdown.vue'

defineProps<{
  pending_tasks: Task[]
}>()
</script>
