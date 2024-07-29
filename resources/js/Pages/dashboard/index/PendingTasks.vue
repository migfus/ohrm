<template>
  <div>
    <BasicCard :icon="TicketIcon" title="Pending Tasks">
      <div class="flex flex-col gap-2">


        <AppInput name="Search" v-model="throttle_search" class="mb-2" noLabel placeholder="Search Task" />


        <div v-if="pending_tasks.length <= 0" class="bg-white p-4 font-medium rounded-2xl shadow text-sm text-brand-500">
          {{ form.search ? 'No task' : 'No task available today 😄' }}
        </div>

        <DataTransition v-else>
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
import { Task } from '@/globalTypes'
import { dateTimeFormatted, taskIdSplitter, defaultRouterState } from '@/converter'
import { router } from '@inertiajs/vue3'
import { useThrottle } from '@vueuse/core'
import { ref, watch, reactive } from 'vue'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon } from '@heroicons/vue/24/solid'
import AppInput from '@/components/form/AppInput.vue'
import TaskDropdown from './TaskDropdown.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'

defineProps<{
  pending_tasks: Task[]
}>()

const throttle_search = ref('')
const form = reactive({
  search: useThrottle(throttle_search, 2000)
})

watch(form, () => {
  router.get(route('dashboard.index'), { search: form.search }, defaultRouterState(['pending_tasks']))
})

function markTask() {
  router.get(route('dashboard.update'), { search: form.search }, defaultRouterState(['pending_tasks']))
}
</script>
