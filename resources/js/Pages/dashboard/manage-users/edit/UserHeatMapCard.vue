<template>
  <BasicCard :icon="ChartBarIcon" title="Tasks' Heatmap" description="Group's heatmap activities.">
    <CalendarHeatmap
      :values="[
        { date: '2024-05-9', count: 6 },
        { date: '2024-05-10', count: 6 },
        { date: '2024-05-11', count: 6 },
      ]"
      end-date="2024-12-31"
      :round="5"
      tooltip-unit="activity"
      class="bg-white py-3 px-4 rounded-xl shadow"
    />
  </BasicCard>
</template>

<script setup lang="ts">
import { CalendarHeatmap } from 'vue3-calendar-heatmap'
import { ChartBarIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'
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
