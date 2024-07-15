<template>
  <DataTransition v-if="counts < 4" class="flex my-4 gap-2">
    <div v-for="block in contents">
      <img :src="block.thumbnail_url" alt="post image"  class="aspect-square object-cover rounded-2xl"/>
    </div>
  </DataTransition>

  <DataTransition v-else class="grid grid-cols-2 my-4 gap-2">
    <div v-for="block, idx in contents.slice(0,4)" class="relative">
      <div v-if="idx > 2 && counts > 4" class="overflow-hidden h-full w-full rounded-2xl flex bg-brand-50/75 shadow">
        <div class="m-auto text-2xl">+ {{ counts - 4 }}</div>
        <img :src="block.thumbnail_url" class="blur-lg absolute aspect-square opacity-25">
      </div>
      <div v-else>
        <img :src="block.thumbnail_url" alt="post image" class="aspect-square object-cover rounded-2xl"/>
      </div>
    </div>
  </DataTransition>
</template>

<script setup lang="ts">
import { PostContent } from '@/globalTypes'
import DataTransition from '../transitions/DataTransition.vue'

defineProps<{
  counts: number
  contents: PostContent[]
}>()
</script>
