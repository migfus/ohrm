<template>
  <div class="mx-4 flex flex-col gap-2">

    <div v-for="com in comments" class="flex gap-2">
      <img :src="com.user.avatar" class="h-4 w-4 rounded-full"/>
      <div class="bg-white rounded-2xl px-3 py-2 text-xs flex flex-col shadow-sm flex-grow">
        <label class="font-medium">{{ com.user.name }} - {{ dateTimeFormatted(com.created_at) }}</label>
        <label class="">{{ com.content }}</label>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import { dateTimeFormatted } from '@/converter'
import { TComment } from '@/globalTypes'

defineProps<{
  comments: TComment[]
}>()
</script>
