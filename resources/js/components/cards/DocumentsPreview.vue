<template>
  <DataTransition class="flex flex-col my-4 gap-2">
    <div v-for="block in contents" class="flex-grow bg-brand-50 rounded-2xl shadow">
      <div class="flex justify-between">
        <div class="flex justify-start truncate">
          <img :src="block.thumbnail_url" :alt="block.name" class="h-8 w-8 inline mr-2 object-cover p-2 bg-white rounded-full shadow m-1" />
          <span class="mt-2">{{ block.name }}.{{ block.data_type }}</span>
        </div>

        <AppButton name="download" size="sm" class="m-1" :icon="ArrowDownIcon">Download</AppButton>
      </div>
    </div>
  </DataTransition>

  <div class="flex justify-end">
    <AppButton :icon="ArrowDownIcon" name="Download All" color="brand" size="sm">Download All</AppButton>
  </div>
</template>

<script setup lang="ts">
import { PostContent } from '@/globalTypes'

import DataTransition from '../transitions/DataTransition.vue'
import AppButton from '../form/AppButton.vue'
import { ArrowDownIcon } from '@heroicons/vue/24/solid'

 defineProps<{
  counts: number
  contents: PostContent[]
  name: string
  title: string
  createdAt: Date
}>()
</script>
