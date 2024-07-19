<template>
  <div class="grid grid-cols-2 my-4 gap-2">
    <div v-for="block in contents" class="flex-grow bg-brand-50 rounded-2xl shadow col-span-2 sm:col-span-1">
      <div class="flex justify-between">
        <div class="flex justify-start truncate">
          <img :src="`/assets/document_icons/${block.data_type}.png`" class="h-8 w-8 inline mr-2 object-cover p-1 bg-white rounded-full shadow m-1" />
          <span class="mt-2">{{ block.name }}.{{ block.data_type }}</span>
        </div>

        <AppButton name="download" size="sm" class="m-1" :icon="ArrowDownIcon" :href="block.file_url" externalLink>Download</AppButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { PostContent } from '@/globalTypes'

import AppButton from '../form/AppButton.vue'
import { ArrowDownIcon } from '@heroicons/vue/24/solid'

defineProps<{
  counts: number
  contents: PostContent[]
  name: string
  title: string
  createdAt: string
}>()
</script>
