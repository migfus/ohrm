<script setup lang="ts">
import { TProps } from '@/globalTypes'
import { useTitle } from '@vueuse/core'

const $props = defineProps<TProps>()

useTitle(`Manage Users | ${$props.title}`)
</script>

<template>
  <div>
    Manage Users
  </div>
</template>
