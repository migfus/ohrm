<template>
  <div>
    <BasicCard
      v-model="throttle_search"
      :icon="CheckCircleIcon"
      title="Completed Tasks"
      enableSearch
      :count="completed_tasks.length"
    >
      <div class="flex flex-col gap-2">

        <div v-if="completed_tasks.length <= 0" class="bg-white p-4 font-medium rounded-2xl shadow text-sm text-brand-500">
          {{ form.search ? 'No task' : 'It seems too empty...' }}
        </div>

        <DataTransition v-else class="flex flex-col gap-2">
          <TaskCard
            v-for="task, index in completed_tasks"
            :key="task.id"
            :task
            :task_status
            :index
            @selectedStatus="selectedStatus"
          />
        </DataTransition>

      </div>
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { Task, TaskStatus } from '@/globalTypes'
import { defaultRouterState, errorAlert } from '@/converter'
import { ref, reactive, watch, onErrorCaptured } from 'vue'
import { useThrottle } from '@vueuse/core'
import { router } from '@inertiajs/vue3'

import BasicCard from '@/components/cards/BasicCard.vue'
import { CheckCircleIcon } from '@heroicons/vue/20/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'
import TaskCard from './TaskCard.vue'

defineProps<{
  completed_tasks: Task[]
  task_status: TaskStatus[]
}>()

const throttle_search = ref('')
const form = reactive({
  search: useThrottle(throttle_search, 2000)
})

watch(form, () => {
  router.get(route('dashboard.index'), { search: form.search }, defaultRouterState(['completed_tasks']))
})

function selectedStatus(task_status_id: string, task_id: string) {
  router.put(route('dashboard.update', { dashboard: task_id }),
    { task_status_id },
    defaultRouterState(['processing_tasks', 'completed_tasks'])
  )
}

onErrorCaptured((e) => errorAlert('/dashboard/index/MarkedTasks', e))
</script>
