<template>
  <div>
    <BasicCard
      :icon="PresentationChartLineIcon"
      title="My Activities"
      description="Whole year tasks activities"
      :count="user_activities[0].count"
    >
      <CalendarHeatmap
        :values="user_activities"
        :end-date="moment().format('YYYY-MM-DD')"
        :round="5"
        tooltip-unit="activity"
        class="bg-white py-3 px-4 rounded-xl shadow"
      />
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import moment from 'moment'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import { PresentationChartLineIcon } from '@heroicons/vue/20/solid'
import { CalendarHeatmap } from 'vue3-calendar-heatmap'
import BasicCard from '@/components/cards/BasicCard.vue'

defineProps<{
  user_activities: {
    date: string,
    count: number
  }[]
}>()

onErrorCaptured((e) => errorAlert('/dashboard/index/MyActivities', e))
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
