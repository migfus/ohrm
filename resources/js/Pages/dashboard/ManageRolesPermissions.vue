<script setup lang="ts">
import { TProps } from '@/globalTypes'
import { useTitle } from '@vueuse/core'

const $props = defineProps<TProps>()

useTitle(`Manage Roles & Permissions | ${$props.title}`)
</script>

<template>
  <div>
    Manage Roles & Permissions
  </div>
</template>


