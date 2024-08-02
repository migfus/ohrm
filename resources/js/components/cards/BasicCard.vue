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
          <div class="pt-1.5 px-1 cursor-pointer hover:bg-white rounded-2xl group/expand" @click="expand = !expand">
            <MinusIcon v-if="expand" class="h-4 w-4 text-brand-800" />
            <div v-else class="flex">
              <div v-if="count" class="bg-white group-hover/expand:bg-gray-100 rounded-full mr-2 text-brand-500 -mt-1 px-2 shadow">{{ count }}</div>
              <StopIcon class="h-4 w-4 text-brand-800" />
            </div>
          </div>
        </div>
        <p v-if="description && expand" class="mt-1 mb-1 max-w-2xl text-sm leading-6 text-gray-500">{{ description }}</p>
      </div>
      <!-- NOTE: BASIC CARD CONTENTS -->
      <div v-if="expand" class="mt-2 transition-all">
        <div v-if="enableSearch" class="flex flex-col sm:flex-row justify-end mb-4">
          <AppInput v-model="$model" name="Search" size="sm" placeholder="Search" noLabel class="sm:w-1/2"/>
        </div>
        <slot></slot>
      </div>
    </div>
  </BasicTransition>

</template>

<script setup lang="ts">
import { FunctionalComponent, ref } from 'vue'

import BasicTransition from '@/components/transitions/BasicTransition.vue'
import { StopIcon, MinusIcon } from '@heroicons/vue/24/outline'
import AppInput from '../form/AppInput.vue'

defineProps<{
  icon?: FunctionalComponent
  iconHtml?: string
  iconImg?: string
  title: string
  description?: string
  size?: 'lg'
  enableSearch?: boolean
  count?: number
}>()

const expand = ref(true)
const $model = defineModel<string>()
</script>

<style scoped>
.loading-card {
  position: relative;
}

@property --angle{
  syntax: "<angle>";
  initial-value: 0deg;
  inherits: false;
}

.loading-card::after, .card::before {
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  z-index: -1;
  padding: 4px;
  border-radius: 15px;
  background-image: conic-gradient(from var(--angle), transparent 70%, #00ff99);
  animation: 3s spin linear infinite;
}
.loading-card::before {
  filter: blur(1.5rem);
  opacity: 0.5;
}

@keyframes spin {
  from {
    --angle: 0deg
  }
  to {
    --angle: 360deg
  }
}
</style>
