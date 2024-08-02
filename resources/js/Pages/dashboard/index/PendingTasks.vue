<template>
  <div>
    <BasicCard
      v-model="throttle_search"
      enableSearch
      :icon="TicketIcon"
      title="Pending Tasks"
      :count="pending_tasks.length"
    >
      <div class="flex flex-col gap-2">

        <div v-if="pending_tasks.length <= 0" class="bg-white p-4 font-medium rounded-2xl shadow text-sm text-brand-500">
          {{ form.search ? 'No task' : 'No task available today 😄' }}
        </div>

        <DataTransition v-else>
          <div v-for="task, index in pending_tasks" :key="task.id" class="bg-white p-4 shadow rounded-2xl font-medium">
            <div class="flex justify-between mb-1">
              <div class="flex">
                <div class="text-sm text-brand-600 mt-1 mr-1">{{ taskIdSplitter(task.id, 'date_time')}}</div>
                <div class="text-brand-900 text-lg"> - #{{ taskIdSplitter(task.id, 'incremental')}}</div>
              </div>
              <div class="text-md text-brand-400">
                <TaskDropdown :task_id="task.id" :index :task_status/>
              </div>
            </div>

            <div class="flex justify-between">
              <div class="flex">
                {{ task.name }}
              </div>
              <div class="text-sm text-brand-400">
                <label>{{ dateTimeFormatted(task.created_at) }}</label>
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

            <div class="flex justify-between mt-3 bg-brand-50 rounded-2xl shadow py-2 px-4">
              <div class="flex text-sm ">
                {{ task.message }}
              </div>
            </div>
          </div>
        </DataTransition>


      </div>
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { Task, TaskStatus } from '@/globalTypes'
import { dateTimeFormatted, taskIdSplitter, defaultRouterState, errorAlert } from '@/converter'
import { router } from '@inertiajs/vue3'
import { useThrottle } from '@vueuse/core'
import { ref, watch, reactive, onErrorCaptured } from 'vue'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon } from '@heroicons/vue/24/solid'
import TaskDropdown from './TaskDropdown.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'

defineProps<{
  pending_tasks: Task[]
  task_status: TaskStatus[]
}>()

const throttle_search = ref('')
const form = reactive({
  search: useThrottle(throttle_search, 2000)
})

watch(form, () => {
  router.get(route('dashboard.index'), { search: form.search }, defaultRouterState(['pending_tasks']))
})

onErrorCaptured((e) => errorAlert('/dashboard/index/PendingTasks', e))
</script>
