<template>
  <BasicCard
    :icon="ChartBarIcon"
    title="Tasks' Heatmap"
    description="Group's heatmap activities."
    :count="now_task_activities"
  >
    <CalendarHeatmap
      :values="group_task_activities_all"
      :end-date="moment().format('YYYY-MM-DD')"
      :round="5"
      tooltip-unit="activity"
      class="bg-white py-3 px-4 rounded-xl shadow"
    />
  </BasicCard>
</template>

<script setup lang="ts">
import moment from 'moment'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import { CalendarHeatmap } from 'vue3-calendar-heatmap'
import { ChartBarIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'

const $props = defineProps<{
  group_task_activities: {
    date: string
    count: number
  }[]
  now_task_activities: number
}>()

const group_task_activities_all = [
  ...$props.group_task_activities,
  {
    date: moment().format('YYYY-MM-DD'),
    count: $props.now_task_activities
  }
]

onErrorCaptured((e) => errorAlert('/dashboard/manage-groups/edit/GroupHeatMapCard', e))
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
