<script setup lang="ts">
import { TProps } from '@/globalTypes'
import { useTitle } from '@vueuse/core'

const $props = defineProps<TProps>()

useTitle(`Joined Groups | ${$props.title}`)
</script>

<template>
  <div>
    Joined Groups
  </div>
</template>
