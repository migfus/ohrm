import { defineStore } from 'pinia'
import { Post } from '@/globalTypes'
import { ref } from 'vue'
import axios from 'axios'

export const usePinnedPostStore = defineStore('pinnedPost', () => {
  const pinned_post_data = ref<Post[]>([])
  const loading = ref<boolean>(false)

  async function getPinnedPosts(group_id: string) {
    loading.value = true
    const res = await axios.get(route('dashboard.pinned-posts.index', { group_id: group_id}))
    pinned_post_data.value = res.data
    loading.value = false
  }

  return { pinned_post_data, loading, getPinnedPosts }
})
