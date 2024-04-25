<script setup lang="ts">
import { TProps } from '@/globalTypes'
import { useTitle } from '@vueuse/core'

const $props = defineProps<TProps>()

useTitle(`Dashboard | ${$props.title}`)
</script>

<template>
  <div class="">Dashboard</div>
</template>
