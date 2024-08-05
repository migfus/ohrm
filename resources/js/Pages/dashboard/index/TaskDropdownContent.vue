<template>
  <MenuItem v-slot="{ active }">
    <button
      :class="[
        active ? 'shadow bg-brand-50' : 'bg-white',
        'group flex w-full items-center rounded-2xl px-2 py-2 text-sm font-medium ',
      ]"
      @click="$emit('selected')"
    >
      <div
        v-html="icon_html"
        :class="[active ? '' : '', 'mr-2 h-4 w-4']"
        aria-hidden="true"
        :style="`color: #${text_color}`"
      >
      </div>
      <slot></slot>
    </button>

  </MenuItem>
</template>

<script setup lang="ts">
import { MenuItem } from '@headlessui/vue'

defineProps<{
  icon_html: string
  bg_color: string
  text_color: string
}>()

const $emit = defineEmits(['selected'])
</script>
