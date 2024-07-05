<template>
  <div v-for="post in posts" :key="post.id">
    <PostCard :post :groupId/>
  </div>
</template>

<script setup lang="ts">
import { TPost } from '@/globalTypes'

import PostCard from '@/components/cards/PostCard.vue'

defineProps<{
  posts: TPost[]
  groupId: string
}>()
</script>
