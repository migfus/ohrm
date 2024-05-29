<template>
  <MenuItem v-slot="{ active }">
    <button
      :class="[
        active ? 'bg-brand-400 text-white shadow' : 'text-gray-900',
        danger && 'text-red-400',
        danger && active ? 'bg-red-400' : '',
        'group flex w-full items-center rounded-2xl px-2 py-2 text-sm',
      ]"
      @click="$emit('selected')"
    >
      <component :is="icon"
        :class="[danger && 'text-red-500', active ? 'text-white' : 'text-gray-500', 'mr-2 h-4 w-4']"
        aria-hidden="true"
      />
      <slot></slot>
    </button>
  </MenuItem>
</template>

<script setup lang="ts">
import { MenuItem } from '@headlessui/vue'
import { FunctionalComponent } from 'vue'

defineProps<{
  icon: FunctionalComponent
  danger?: boolean
}>()

const $emit = defineEmits(['selected'])
</script>
