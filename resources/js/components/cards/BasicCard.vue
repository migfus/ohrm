<template>
  <BasicTransition>
    <div :class="[size === 'lg' && 'p-6', 'bg-brand-50 p-4 shadow sm:rounded-2xl group transition-all']">
      <div class="">
        <div class="flex justify-between">
          <h3 class="text-base font-semibold leading-7 text-gray-900">
            <component v-if="icon" :is="icon" class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
            <img v-else-if="iconImg" :src="iconImg" class="inline mr-2 w-6 h-6 rounded shadow"/>
            <div v-else class="inline-block h-4 w-4 pt-[2px] text-brand-700" v-html="iconHtml"></div>
            {{ title }}
          </h3>
        </div>

        <p v-if="description" class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">{{ description }}</p>
      </div>

      <div class="mt-4">
        <slot></slot>
      </div>
  </div>
  </BasicTransition>
</template>

<script setup lang="ts">
import { FunctionalComponent } from 'vue'

import BasicTransition from '@/components/transitions/BasicTransition.vue'

defineProps<{
  icon?: FunctionalComponent
  iconHtml?: string
  iconImg?: string
  title: string
  description?: string
  size?: 'lg'
}>()
</script>
