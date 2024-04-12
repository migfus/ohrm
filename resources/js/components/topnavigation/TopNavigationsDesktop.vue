<template>
  <Link :class="[
    $props.active ? 'inline-flex items-center border-b-2 border-brand-500 px-1 pt-1 text-sm font-medium text-gray-900' :
      'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 mouse-pointer'
    ]"
    :href="$props.href"
  >
    <component v-if="icon" :is="icon" class="h-6 w-6 text-brand-700" aria-hidden="true" />
    <!-- {{ $props.name }} -->
  </Link>
</template>

<script setup lang="ts">
import { TCTopNavigation } from '@/globalTypes'


const $props = defineProps<TCTopNavigation>()
</script>
