<template>
  <BasicTransition>
    <!-- NOTE: REDIRECT MODE -->
    <a
      v-if="externalLink"
      :href
      targe="_blank"
      :type
      :disabled="loading"
      :class="[
        buttonColor,
        textAlignment,
        buttonSize,
        'inline-flex rounded-2xl font-medium shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all'
      ]"
      @click="clicked = true"
    >
      <ArrowPathIcon v-if="loading && !noLoading" :class="[$props.size == 'sm' && 'h-[15px] w-[15px] mt-[1px]', '-ml-1 mr-2 h-5 w-5 animate-spin', iconColor]" aria-hidden="true" />
      <component v-else-if="icon" :is="icon" :class="[$props.size == 'sm' && 'h-[15px] w-[15px] mt-[1px]', '-ml-1 mr-2 h-5 w-5', iconColor]" aria-hidden="true" />
      <slot></slot>
    </a>
    <!-- NOTE: LINK MODE -->
    <Link
      v-else-if="href"
      :href
      :type
      :disabled="loading"
      :class="[
        buttonColor,
        textAlignment,
        buttonSize,
        'inline-flex rounded-2xl font-medium shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all'
      ]"
      @click="clicked = true"
    >
      <ArrowPathIcon v-if="loading && !noLoading" :class="[$props.size == 'sm' && 'h-[15px] w-[15px] mt-[1px]', '-ml-1 mr-2 h-5 w-5 animate-spin', iconColor]" aria-hidden="true" />
      <component v-else-if="icon" :is="icon" :class="[$props.size == 'sm' && 'h-[15px] w-[15px] mt-[1px]', '-ml-1 mr-2 h-5 w-5', iconColor]" aria-hidden="true" />
      <slot></slot>
    </Link>

    <!-- NOTE: BUTTON MODE [default]-->
    <button
      v-else
      :type
      :disabled="loading"
      :class="[
        buttonColor,
        textAlignment,
        buttonSize,
        'inline-flex rounded-2xl font-medium shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all'
      ]"
      @click="clicked = true"
    >
      <ArrowPathIcon v-if="loading && !noLoading" :class="[$props.size == 'sm' && 'h-[15px] w-[15px] mt-[1px]', '-ml-1 mr-2 h-5 w-5 animate-spin', iconColor]" aria-hidden="true" />
      <component v-else-if="icon" :is="icon" :class="[$props.size == 'sm' && 'h-[15px] w-[15px] mt-[1px]', '-ml-1 mr-2 h-5 w-5', iconColor]" aria-hidden="true" />
      <slot></slot>
    </button>
  </BasicTransition>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { FunctionalComponent, ref, computed } from 'vue'

import { ArrowPathIcon } from '@heroicons/vue/24/solid'
import BasicTransition from '@/components/transitions/BasicTransition.vue'

const $props = defineProps<{
  icon?: FunctionalComponent
  color?: string
  type?: 'button' | 'submit' | 'reset',
  alignment?: 'l' | 'c' | 'r',
  size?: 'sm' | 'md'
  href?: string
  externalLink?: boolean
  noLoading?: boolean
}>()
const loading = ref(false)
const clicked = ref(false)

const buttonColor = computed(() => {
  switch($props.color) {
    case 'brand-dark':
      return 'bg-brand-50 hover:bg-brand-100 text-brand-700 focus:ring-brand-500'
    case 'brand':
      return 'bg-brand-600 hover:bg-brand-700 text-brand-50 focus:ring-brand-500'
    case 'danger':
      return 'bg-red-50 text-red-700 hover:bg-red-100 focus:ring-red-500'
    default:
      return 'bg-white hover:bg-gray-50 text-brand-700 hover:bg-gray-100 focus:ring-brand-500'
  }
})

const iconColor = computed(() => {
  switch($props.color) {
    case 'danger':
      return 'text-red-700'
    case 'brand':
      return 'text-brand-50'
    default:
      return 'text-brand-700'
  }
})

const textAlignment = computed(() => {
  switch($props.alignment) {
    case 'l':
      return 'justify-left'
    default:
      return 'justify-center'
  }
})
// NOTE: [sm/default]
const buttonSize = computed(() => {
  switch($props.size) {
    case 'sm':
      return 'text-xs font px-3 py-2'
    default:
      return 'text-sm px-4 py-2'
  }
})

// NOTE: Loading Animation
router.on('start', () => {
  if(clicked.value) {
    loading.value = true
  }
})

router.on('finish',() => {
  loading.value = false
})
</script>
