<template>
  <div class="bg-brand-50 mb-4 shadow rounded-xl p-4 block">
    <div class="px-4 sm:px-0 mb-4">
      <h3 class="text-base font-semibold leading-7 text-gray-900">
        <ChartBarIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
        User's Task Activities
      </h3>
      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Modify basic information of the user.</p>
    </div>

    <CalendarHeatmap
      :values="[
        { date: '2024-05-9', count: 6 },
        { date: '2024-05-10', count: 6 },
        { date: '2024-05-11', count: 6 },
      ]"
      end-date="2024-12-31"
      :round="5"

      tooltip-unit="activity"
    />
  </div>
</template>

<script setup lang="ts">
import { CalendarHeatmap } from 'vue3-calendar-heatmap'
import { ChartBarIcon } from '@heroicons/vue/24/solid'
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
