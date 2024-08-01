<template>
  <BasicCard :icon="TicketIcon" title="Recent Tasks">
    <OverflowNavigation :slides="all_task_templates"/>

    <DataTransition class="flex flex-col gap-2">
      <TaskCard v-for="task in tasks" :task :key="task.id" />
    </DataTransition>
  </BasicCard>
</template>

<script setup lang="ts">
import { Task, TaskTemplate } from '@/globalTypes'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon } from '@heroicons/vue/24/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'
import TaskCard from '@/components/data/TaskCard.vue'
import OverflowNavigation from '@/components/navigations/OverflowNavigation.vue'

const $props = defineProps<{
  tasks: Task[]
  taskTemplates: TaskTemplate[]
}>()

const all_task_templates = [
  {
    display_name: 'All Tasks',
    link: '/all/tasks',
  },
  ...$props.taskTemplates.map(function(r) {
    return {
      display_name: r.name,
      link: `/all/tasks/${r.id}`,
    }
  })
]
</script>
