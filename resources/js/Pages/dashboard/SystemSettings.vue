<script setup lang="ts">
import { TProps } from '@/globalTypes'
import { useTitle } from '@vueuse/core'

const $props = defineProps<TProps>()

useTitle(`System Settings | ${$props.title}`)
</script>

<template>
  <div>
    System Settings
  </div>
</template>
