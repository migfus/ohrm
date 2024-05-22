<template>
  <slot></slot>
  <div class="mb-4">
    <div class="sm:hidden">
      <label for="tabs" class="sr-only">Select a tab</label>
      <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
      <select v-model="$model" id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-brand-500 focus:ring-brand-500">
        <option v-for="(tab, index) in data" :key="tab.display_name" :value="index">{{ tab.display_name }}</option>
      </select>
    </div>
    <div class="hidden sm:block">
      <div class="border-b border-gray-200">
        <nav>
          <DataTransition class="-mb-px flex space-x-4" aria-label="Tabs">
            <TabSectionContent
              v-for="tab, index in data"
              :key="tab.display_name"
              :display_name="tab.display_name"
              :index="index"
              :icon="tab.icon"
              :disableLoading
              v-model="$model"
            />
          </DataTransition>

        </nav>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TTab } from '@/globalTypes'
import { watch } from 'vue'

import DataTransition from '../transitions/DataTransition.vue'
import TabSectionContent from './TabSectionContent.vue'

const $model = defineModel<number>()
const $emits = defineEmits(['selectedData'])
const $props = defineProps<{
  data: TTab[]
  disableLoading?: boolean
}>()

watch($model, () => {
  $emits('selectedData', $props.data[$model.value ?? 0])
})

</script>
