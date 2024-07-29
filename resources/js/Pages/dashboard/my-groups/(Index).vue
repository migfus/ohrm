<template>
  <div class="grid grid-cols-2 gap-4">
    <PostSection :posts groupId="123" class="col-span-2 order-2 lg:order-1 lg:col-span-1" />
    <MyGroupsCard :groups class="col-span-2 lg:col-span-1 order-1"/>
  </div>
</template>

<script setup lang="ts">
import { Group, Post } from '@/globalTypes'

import MyGroupsCard from './MyGroupsCard.vue'
import PostSection from './posts/PostSection.vue'

defineProps<{
  groups: Group[]
  posts: Post[]
}>()
</script>
