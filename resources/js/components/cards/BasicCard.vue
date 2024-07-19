<template>
  <!-- ✅ -->
  <BasicTransition>
    <div :class="[size === 'lg' && 'p-6', 'bg-brand-50 p-4 shadow sm:rounded-2xl group transition-all']">
        <!-- NOTE: BASIC CARD HEADER -->
      <div>
        <div class="flex justify-between">
          <h3 class="text-base font-semibold leading-7 text-gray-900 truncate">
            <component v-if="icon" :is="icon" class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
            <img v-else-if="iconImg" :src="iconImg" class="inline mr-2 w-6 h-6 rounded shadow"/>
            <div v-else class="inline-block h-4 w-4 pt-[2px] text-brand-700 mr-2" v-html="iconHtml"></div>
            <span>{{ title }} </span>
          </h3>
          <div class="pt-1.5 px-1 rounded cursor-pointer hover:bg-white" @click="expand = !expand">
            <MinusIcon v-if="expand" class="h-4 w-4 text-brand-800" />
            <StopIcon v-else class="h-4 w-4 text-brand-800" />
          </div>
        </div>
        <p v-if="description && expand" class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">{{ description }}</p>
      </div>
      <!-- NOTE: BASIC CARD CONTENTS -->
      <div v-if="expand" class="mt-4 transition-all">
        <slot></slot>
      </div>
    </div>
  </BasicTransition>


</template>

<script setup lang="ts">
import { FunctionalComponent, ref } from 'vue'

import BasicTransition from '@/components/transitions/BasicTransition.vue'
import { StopIcon, MinusIcon } from '@heroicons/vue/24/outline'

defineProps<{
  icon?: FunctionalComponent
  iconHtml?: string
  iconImg?: string
  title: string
  description?: string
  size?: 'lg'
}>()

const expand = ref(true)
</script>
