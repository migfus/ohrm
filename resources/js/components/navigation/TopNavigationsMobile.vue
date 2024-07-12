<template>
  <DisclosureButton
    as="a"
    :href
    :class="[
      components.some(row => row === $page.component) ?
        'block border-l-4 border-brand-500 bg-brand-50 py-2 pl-3 pr-4 text-base font-medium text-brand-700' :
        'block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700'
    ]"
  >
    <!-- NOTE: ICON -->
    <component v-if="icon" :is="icon" class="h-6 w-6 text-brand-700 inline mr-2" aria-hidden="true" />
    <!-- NOTE: NAME -->
    <span class="inline">{{ name }}</span>
  </DisclosureButton>
</template>

<script setup lang="ts">
import { FunctionalComponent } from 'vue'

import { DisclosureButton } from '@headlessui/vue'

defineProps<{
  name: string
  href: string
  components: string []
  icon?: FunctionalComponent
}>()
</script>
