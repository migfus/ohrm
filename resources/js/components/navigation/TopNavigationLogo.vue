<script setup lang="ts">
const $props = defineProps<{
  logo: string
  title: string
}>()
</script>

<template>
    <img class="block h-8 w-auto lg:hidden mr-4" :src="$props.logo" width="10" height="10" :alt="`${$props.title} Logo`" />
    <img class="hidden h-8 w-auto lg:block mr-4" :src="$props.logo" width="10" height="10" :alt="`${$props.title} Logo`" />
</template>
