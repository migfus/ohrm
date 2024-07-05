<template>
  <BasicCard :icon="MapPinIcon" title="Pinned Posts" description="Pinned Post (as announcement)">
    <div class="flex flex-col gap-2">
      <PinnedPostCard v-for="post in posts" :key="post.id" :post :groupId/>
    </div>
  </BasicCard>
</template>

<script setup lang="ts">
import { TPost } from '@/globalTypes'

import BasicCard from '@/components/cards/BasicCard.vue'
import { MapPinIcon } from '@heroicons/vue/20/solid'
import PinnedPostCard from '@/components/cards/PinnedPostCard.vue'

defineProps<{
  posts: TPost[]
  groupId: string
}>()
</script>
