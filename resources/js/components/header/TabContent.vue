<template>
  <div class="mb-4">
    <div class="sm:hidden">
      <label for="tabs" class="sr-only">Select a tab</label>
      <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
      <select v-model="$model" id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-brand-500 focus:ring-brand-500">
        <option v-for="(tab, index) in data" :key="tab.name" :value="index">{{ tab.name }}</option>
      </select>
    </div>
    <div class="hidden sm:block">
      <div class="border-b border-gray-200">
        <nav>
          <DataTransition class="-mb-px flex space-x-8" aria-label="Tabs">
            <div
              v-for="tab, index in data"
              :key="tab.name"
              @click="$model = index"
              :class="[index == $model ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium cursor-pointer']"
              :aria-current="index == $model ? 'page' : undefined"
            >
              <component :is="tab.icon" :class="[index == $model ? 'text-brand-500' : 'text-gray-400 group-hover:text-gray-500', '-ml-0.5 mr-2 h-5 w-5']" aria-hidden="true" />
              <span>{{ tab.name }}</span>
            </div>
          </DataTransition>

        </nav>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TTab } from '@/globalTypes'

import DataTransition from '../transitions/DataTransition.vue'

const $model = defineModel<number>()
defineProps<{
  data: TTab[]
}>()

</script>
