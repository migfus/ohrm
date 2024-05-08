<template>
  <div class="border-b border-gray-200 pb-5 mb-4">
    <h1 class="text-semibold font-semibold text-gray-900 text-xl">{{ title }}</h1>
    <p class="mt-2 max-w-4xl text-sm text-gray-500">{{ desc }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
  desc: string
}>()
</script>
