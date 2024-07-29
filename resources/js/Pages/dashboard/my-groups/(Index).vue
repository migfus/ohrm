<template>
  <div class="grid grid-cols-3 gap-4">
    <PostsCard :posts class="col-span-2" />
    <MyGroupsCard :groups class="col-span-1"/>
  </div>
</template>

<script setup lang="ts">
import { Group, Post } from '@/globalTypes'

import MyGroupsCard from './MyGroupsCard.vue'
import PostsCard from './PostsCard.vue'

defineProps<{
  groups: Group[]
  posts: Post[]
}>()
</script>
