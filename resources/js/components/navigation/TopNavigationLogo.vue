<template>
  <img class="block h-7 w-auto lg:hidden mr-4" :src="logo" width="10" height="10" :alt="`${title} Logo`" />
  <img class="hidden h-7 w-auto lg:block mr-4" :src="logo" width="10" height="10" :alt="`${title} Logo`" />
</template>

<script setup lang="ts">
defineProps<{
  logo: string
  title: string
}>()
</script>
