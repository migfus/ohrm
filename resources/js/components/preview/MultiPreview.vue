<template>
  <BasicTransition>
    <div>
      <div v-if="counts > 0" class="absolute flex flex-col justify-center bg-brand-400/75 h-full w-full rounded-2xl items-center z-10">
        <label class="text-2xl text-white">+{{ counts }}</label>
      </div>

      <div v-if="isVideo(preview.thumbnail_url)" class="flex justify-center">
        <video controls class="object-cover shadow rounded-lg">
          <source :src="preview.thumbnail_url" type="video/mp4">
        </video>
      </div>

      <img v-else :src="preview.thumbnail_url" alt="post image" class="aspect-square object-cover rounded-lg shadow" />
    </div>
  </BasicTransition>
</template>

<script setup lang="ts">
import { isVideo } from '@/converter'

import BasicTransition from '@/components/transitions/BasicTransition.vue'

defineProps<{
  preview: {
    thumbnail_url: string
    file_url: string
  }
  counts: number
}>()
</script>
