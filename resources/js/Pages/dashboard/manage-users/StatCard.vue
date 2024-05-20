<template>
  <div class="bg-brand-50 rounded-xl shadow p-4">
    <div class="px-4 sm:px-0">
      <h3 class="text-base font-semibold leading-7 text-gray-900">
        <ChartBarIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
        User's Task Activities
      </h3>
      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Modify basic information of the user.</p>
    </div>

    <LineChart :chartData="testData" />
  </div>
</template>

<script setup lang="ts">
import { LineChart } from 'vue-chart-3'
import { Chart, registerables } from "chart.js"

import { ChartBarIcon } from '@heroicons/vue/24/solid'

Chart.register(...registerables)

const testData = {
  labels: ['4/27', '4/28', '4/29', '4/30', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10','11', '12', '13', '14', '15','16'],
  datasets: [
    {
      label: 'Team 1 Tasks',
      data: [4, 1, 1, 1, 0, 3, 1, 0, 0, 0, 0, 0, 2, 1, 4, 4, 4, 2, 1, 2],
      borderColor: '#77CEFF',
      backgroundColor: '#77CEFF',
    },
    {
      label: 'Team 1 Tasks',
      data: [2, 4, 5, 1, 0, 2, 1, 3, 5, 3, 0, 0, 1, 0, 0, 1, 2, 1, 3, 4],
      borderColor: '#FFB1C1',
      backgroundColor: '#FFB1C1',
    },
  ],
}
</script>
