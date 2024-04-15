<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { FunctionalComponent, computed, onMounted, ref } from 'vue'
import { ArrowPathIcon } from '@heroicons/vue/24/outline'

const $props = defineProps<{
  icon?: FunctionalComponent
  color?: string
  type?: 'button' | 'submit' | 'reset',
  alignment?: 'l' | 'c' | 'r'
}>()
const loading = ref(false)

const buttonColor = computed(() => {
  if(!$props.color) {
    return 'bg-white hover:bg-gray-50 text-brand-700 hover:bg-gray-100 focus:ring-brand-500 '
  }
  else if($props.color == 'brand-dark') {
    return 'bg-brand-50 hover:bg-brand-100 text-brand-700 focus:ring-brand-500 '
  }
  else if($props.color == 'brand') {
    return 'bg-brand-600 hover:bg-brand-700 text-brand-50 focus:ring-brand-500 '
  }
})

const iconColor = computed(() => {
  if(!$props.color) {
    return 'text-brand-700'
  }
  else if($props.color == 'brand') {
    return 'text-brand-50'
  }
})

const textAlignment = computed(() => {
  if(!$props.alignment) {
    return 'justify-center'
  }
  else if($props.alignment == 'l') {
    return 'justify-left'
  }
})


router.on('start', () => {
    loading.value = true
})

router.on('finish',() => {
  loading.value = false
})
</script>

<template>
  <button
    :type
    :disabled="loading"
    :class="[
      buttonColor,
      textAlignment,
      'inline-flex rounded-md px-4 py-2 text-sm font-medium shadow focus:outline-none focus:ring-2 focus:ring-offset-2'
    ]"
  >
    <ArrowPathIcon v-if="loading" :class="['-ml-1 mr-2 h-5 w-5 animate-spin', iconColor]" aria-hidden="true" />
    <component v-else-if="icon" :is="icon" :class="['-ml-1 mr-2 h-5 w-5', iconColor]" aria-hidden="true" />
    <slot></slot>
  </button>
</template>
