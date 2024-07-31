<template>
  <div>
    <!-- SECTION: POSTS DATA -->
    <div ref="infiniteScroll">

      <DataTransition class="flex flex-col gap-4">
        <div v-for="post, index in AuthPostStore.post_data" :key="post.id">
          <PostCard
            :post
            :index
          />
        </div>
      </DataTransition>
    </div>

    <!-- NOTE: Loading/No Data -->
    <div v-if="AuthPostStore.loading" class="bg-brand-50 sm:rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow mt-4">
      <ArrowPathIcon class="h-4 w-4 text-brand-600 animate-spin mr-2 mt-[5px]" />
      Loading...
    </div>
    <div v-if="AuthPostStore.last_page < AuthPostStore.page" class="bg-brand-50 sm:rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow mt-4">
      <FaceSmileIcon class="h-4 w-4 text-brand-600 mr-2 mt-[5px]" />
      No post available. Have a good day!
    </div>

    <RemovalPrompt
      v-model="AuthPostStore.open_prompt_delete_post"
      title="Remove Post?"
      confirm="Yes! Remove this Post"
      @confirm="AuthPostStore.removePostApi()"
    >
      Do you want to remove this post?
    </RemovalPrompt>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useAuthPostStore } from '@/stores/AuthPostStore'
import { useReactionStore } from '@/stores/ReactionStore'

import PostCard from './PostCard.vue'
import {
  ArrowPathIcon,
  FaceSmileIcon,
} from '@heroicons/vue/24/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'

const AuthPostStore = useAuthPostStore()
const ReactionStore = useReactionStore()
const infiniteScroll = ref<HTMLElement | null>(null)

function handleScroll() {
  let element = infiniteScroll.value
  if(element) {
    if(element?.getBoundingClientRect().bottom < window.innerHeight && !AuthPostStore.loading) {
      AuthPostStore.getMorePostApi(handleScroll)
    }
  }
}

onMounted(async () => {
  window.addEventListener('scroll', handleScroll)
  ReactionStore.getReactions()
  AuthPostStore.page = 1
  AuthPostStore.getMorePostApi(handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  ReactionStore.reaction_data = []
  AuthPostStore.post_data = []
})
</script>
