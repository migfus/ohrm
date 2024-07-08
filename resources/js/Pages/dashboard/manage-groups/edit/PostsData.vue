<template>
  <div class="flex flex-col gap-4" ref="postsContent">
    <div v-for="post in posts" :key="post.id">
      <PostCard :post :groupId/>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import { TPost } from '@/globalTypes'
import { useScroll } from '@vueuse/core'
import axios from 'axios'

import PostCard from '@/components/cards/PostCard.vue'

const $props = defineProps<{
  groupId: string
}>()

const posts = ref<TPost[]>([])
const page = ref(1)
const edit = ref<HTMLElement | null>(null)
const { x, y, isScrolling, arrivedState, directions } = useScroll(edit)


async function getPosts() {
  const response = await axios.get<{data: TPost[]}>(`/dashboard/manage-posts?group_id=${$props.groupId}&page=${page.value}`)
  posts.value = response.data.data
}

onMounted(() => {
  getPosts()
})
</script>
