<template>
  <div>
    <div ref="infinite">
      <DataTransition class="flex flex-col gap-4">
        <div v-for="post in posts" :key="post.id">
          <PostCard :post :groupId/>
        </div>
      </DataTransition>
    </div>


    <div v-if="loading" class="bg-brand-50 rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow">
      <ArrowPathIcon class="h-4 w-4 text-brand-600 animate-spin mr-2 mt-[5px]" />
      Loading...
    </div>
    <div v-if="lastPage <= page" class="bg-brand-50 rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow">
      <FaceSmileIcon class="h-4 w-4 text-brand-600 mr-2 mt-[5px]" />
      No post available. Have a good day!
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, inject} from 'vue'
import { TPost } from '@/globalTypes'
import axios from 'axios'
import Echo from 'laravel-echo'

import PostCard from '@/components/cards/PostCard.vue'
import { ArrowPathIcon, FaceSmileIcon } from '@heroicons/vue/24/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'

const $props = defineProps<{
  groupId: string
}>()

// NOTE: POSTS
const posts = ref<TPost[]>([])
const page = ref(1)
const lastPage = ref(1)
const infinite = ref<HTMLElement | null>(null)
const loading = ref(false)
const echo = inject<Echo>('echo')

async function getPosts() {
  const response = await axios.get<{data: TPost[], last_page: number}>(`/dashboard/manage-posts?group_id=${$props.groupId}&page=${page.value}`)
  posts.value.push(...response.data.data)
  lastPage.value = response.data.last_page
}

onMounted(async () => {
  await getPosts()
  window.addEventListener('scroll', handleScroll)

  echo?.channel(`group-posts-update.${$props.groupId}`)
  .listen('UpdateGroupPostsEvent', () => {
    page.value = 1
    posts.value = []
    getPosts()
    console.log('update-status-page-channel connected')
  })
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  echo?.leaveChannel(`group-posts-update.${$props.groupId}`)
})

const handleScroll = () => {
  let element = infinite.value
  if(element) {
    if(element?.getBoundingClientRect().bottom < window.innerHeight && !loading.value) {
      loadMore()
    }
  }
}

async function loadMore() {
  loading.value = true
  page.value++
  if(page.value <= lastPage.value) {
    await getPosts()
  }
  loading.value = false
}
</script>
