<template>
  <div class="bg-brand-50 shadow sm:rounded-2xl text-brand-800">
    <!-- NOTE: POSTCARD HEADER -->
    <div class="flex font-medium justify-between px-4 pt-4 pb-2">
      <Link :href="`/dashboard/manage-users/${post.user.id}/edit`" class="flex">
        <img :src="post.user.avatar" class="h-8 w-8 rounded-full shadow mr-2" />
        <div class="flex flex-col">
          <span class="text-sm">{{ post.user.name }}</span>
          <span class="text-xs">{{ moment(post.created_at).fromNow(true) }}</span>
        </div>
      </Link>
      <div class="text-sm font-regular py-0 my-0 cursor-pointer flex">
        <MapPinIcon v-if="post.is_pinned" class="h-4 w-4 mt-[2px] text-brand-500 cursor-default"/>
        <PostDropown @click="dropDownEmit" :isPinned="post.is_pinned"/>
      </div>
    </div>

    <!-- NOTE: POSTCARD CONTENTS -->
    <div ref="sentenceLines" class="m-1 bg-white px-4 py-2 rounded-lg mx-4 shadow">
      <div v-if="minimizeContent" v-html="quillContentToHtml(post.content)" class="line-clamp-4" ></div>
      <div v-else v-html="quillContentToHtml(post.content)"></div>
    </div>

    <button v-if="height > 95" class="mx-4 text-sm" @click="minimizeContent = !minimizeContent">{{ minimizeContent ? 'Show More...' : 'Show Less...'}}</button>

    <!-- NOTE: POSTCARD FOOTER -->
    <div class="flex justify-between mx-4 py-2 text-sm gap-4">
      <span class="text">😅</span>
      <span class="cursor-pointer">0 Comments</span>
    </div>

    <!-- NOTE: AUTH COMMENT -->
    <PostCommentCard />

  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useElementSize } from '@vueuse/core'
import { TPost, TPostContent } from '@/globalTypes'
import { Quill } from '@vueup/vue-quill'
import moment from 'moment'
import { router } from '@inertiajs/vue3'

import PostCommentCard from './PostCommentCard.vue'
import PostDropown from './PostDropown.vue'
import { MapPinIcon } from '@heroicons/vue/24/solid'

const $props = defineProps<{
  post: TPost
  groupId: string
}>()

const minimizeContent = ref(true)
const sentenceLines = ref(null)
const { height } = useElementSize(sentenceLines)

function quillContentToHtml(content: string) {
  const _content: TPostContent[] = JSON.parse(content)
  if(_content && typeof _content === 'object') {
    const quill = new Quill(document.createElement('div'))
    quill.setContents(
      _content.filter(r => r.insert == null ? false : true)
    )
    return quill.root.innerHTML
  }
  return _content
}
// NOTE: Emits from Dropdown
function dropDownEmit(value: string) {
  switch(value) {
    case 'delete':
      removePost($props.post.id)
      break;
    case 'pin':
      pinPost($props.post.id)
      break;
  }
}
// NOTE: Remove by [Auth]
function removePost(id: string) {
  router.delete(`/dashboard/manage-posts/${id}?redirect=/dashboard/manage-groups/${$props.groupId}/edit`, { preserveScroll: true, preserveState: true})
}
// NOTE: Pin/Unpin By [admin/Mod]
function pinPost(id: string) {
  router.put(`/dashboard/manage-posts/${id}?redirect=/dashboard/manage-groups/${$props.groupId}/edit`,
    { type: 'pin' },
    { preserveScroll: true, preserveState: true }
  )
}
</script>
