<script setup lang="ts">
import { TProps } from '@/globalTypes'
import { useTitle } from '@vueuse/core'

const $props = defineProps<TProps>()

useTitle(`Manage Groups | ${$props.title}`)
</script>

<template>
  <div>
    Manage Groups
  </div>
</template>
