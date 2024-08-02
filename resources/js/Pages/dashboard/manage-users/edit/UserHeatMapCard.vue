<template>
  <BasicCard :icon="ChartBarIcon" title="Tasks' Heatmap" description="Group's heatmap activities.">
    <CalendarHeatmap
      :values="task_activity_all"
      :end-date="moment().format('YYYY-MM-DD')"
      :round="5"
      tooltip-unit="activity"
      class="bg-white py-3 px-4 rounded-xl shadow"
    />
  </BasicCard>
</template>

<script setup lang="ts">
import moment from 'moment'
import { errorAlert } from '@/converter'
import { onErrorCaptured } from 'vue'

import { CalendarHeatmap } from 'vue3-calendar-heatmap'
import { ChartBarIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'

const $props = defineProps<{
  task_activity: {
    date: string
    count: number
  }[]
  task_count_now: number
}>()

const task_activity_all = [{
    date: moment().format('YYYY-MM-DD'),
    count: $props.task_count_now
  },
  ...$props.task_activity
]

onErrorCaptured((e) => errorAlert('/dashboard/manage-users/edit/UserHeatMapCard', e))
</script>

<style>
.vch__months__labels__wrapper, .vch__days__labels__wrapper:first-letter{
  font-size: 0.9em;
}
.vch__days__labels__wrapper {
  display:block;
  visibility: hidden;
}
.vch__days__labels__wrapper:first-letter {
  visibility: visible;
}
.vch__legend {
  display: flex;
  gap: 1em;
}
.vch__external-legend-wrapper {
  margin-top: 7px !important;
}
</style>
