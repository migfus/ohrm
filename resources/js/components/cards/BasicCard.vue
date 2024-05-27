<template>
  <BasicTransition>
    <div class="bg-brand-50 p-4 shadow rounded-xl group">
      <div class="px-4 sm:px-0">
        <div class="flex justify-between">
          <h3 class="text-base font-semibold leading-7 text-gray-900">
            <component :is="icon" class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
            {{ title }}
          </h3>
        </div>

        <p v-if="description" class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">{{ description }}</p>
      </div>

      <div class="mt-6">
        <slot></slot>
      </div>
  </div>
  </BasicTransition>
</template>

<script setup lang="ts">
import { FunctionalComponent } from 'vue'

import BasicTransition from '@/components/transitions/BasicTransition.vue'

defineProps<{
  icon: FunctionalComponent
  title: string
  description?: string
}>()
</script>
