<template>
  <BasicCard
    :icon="MapPinIcon"
    title="Pinned Posts" description="Pinned Post (as announcement)" :count="PinnedPostStore.pinned_post_data.length">
    <div class="flex flex-col gap-2">
      <PinnedPostCard v-for="post in PinnedPostStore.pinned_post_data" :key="post.id" :post :groupId/>
    </div>
  </BasicCard>
</template>

<script setup lang="ts">
import { onMounted, onErrorCaptured } from 'vue'
import { usePinnedPostStore } from '@/stores/PinnedPostStore'
import { errorAlert } from '@/converter'

import BasicCard from '@/components/cards/BasicCard.vue'
import { MapPinIcon } from '@heroicons/vue/20/solid'
import PinnedPostCard from './PinnedPostCard.vue'

const $props = defineProps<{
  groupId: string
}>()

const PinnedPostStore = usePinnedPostStore()

onMounted(() => {
  PinnedPostStore.getPinnedPosts($props.groupId)
})

onErrorCaptured((e) => errorAlert('/dashboard/manage-groups/edit/pinned-posts/PinnedPostsCard', e))
</script>
