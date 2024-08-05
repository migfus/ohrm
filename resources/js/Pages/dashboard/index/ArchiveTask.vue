<template>
  <div>
    <BasicCard
      v-model="throttle_search"
      :icon="Square3Stack3DIcon"
      title="Archived Tasks"
      enableSearch
      :count="archive_tasks.data.length"
    >
      <div class="flex flex-col gap-2">

        <div v-if="archive_tasks.data.length <= 0" class="bg-white p-4 font-medium rounded-2xl shadow text-sm text-brand-500">
          {{ form.search ? 'No task' : 'It seems too empty...' }}
        </div>

        <DataTransition v-else class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-2">
          <TaskCard
            v-for="task, index in archive_tasks.data"
            :key="task.id"
            :task
            :task_status
            :index
            @selectedStatus="selectedStatus"
          />
        </DataTransition>
      </div>
    </BasicCard>

    <PaginationCard :data="archive_tasks" @changePage="getArchive"/>
  </div>
</template>

<script setup lang="ts">
import { Pagination, Task, TaskStatus } from '@/globalTypes'
import { defaultRouterState, errorAlert } from '@/converter'
import { ref, reactive, watch, onErrorCaptured } from 'vue'
import { useThrottle } from '@vueuse/core'
import { router } from '@inertiajs/vue3'

import BasicCard from '@/components/cards/BasicCard.vue'
import { Square3Stack3DIcon } from '@heroicons/vue/20/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'
import TaskCard from './TaskCard.vue'
import PaginationCard from '@/components/data/PaginationCard.vue'

defineProps<{
  archive_tasks: Pagination<Task>
  task_status: TaskStatus[]
}>()

const throttle_search = ref('')
const form = reactive({
  search: useThrottle(throttle_search, 2000)
})

function getArchive(page = 1) {
  router.get(route('dashboard.index'), { search: form.search, page }, defaultRouterState(['archive_tasks']))
}

watch(form, () => {
  router.get(route('dashboard.index'), { search: form.search }, defaultRouterState(['archive_tasks']))
})

function selectedStatus(task_status_id: string, task_id: string) {
  router.put(route('dashboard.update', { dashboard: task_id }),
    { task_status_id },
    defaultRouterState(['archive_tasks'])
  )
}

onErrorCaptured((e) => errorAlert('/dashboard/index/ArchiveTask', e))
</script>
