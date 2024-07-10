<template>
  <div class="bg-brand-50 shadow sm:rounded-2xl text-brand-800">
    <!-- NOTE: POSTCARD HEADER -->
    <div class="flex font-medium justify-between px-4 pt-4 pb-2">
      <Link :href="`/dashboard/manage-users/${_post.user.id}/edit`" class="flex">
        <img :src="_post.user.avatar" class="h-8 w-8 rounded-full shadow mr-2" />
        <div class="flex flex-col">
          <span class="text-sm">{{ _post.user.name }}</span>
          <span class="text-xs">{{ dateTimeFormatted(_post.created_at) }}</span>
        </div>
      </Link>
      <div class="text-sm font-regular py-0 my-0 cursor-pointer flex">
        <MapPinIcon v-if="_post.is_pinned" class="h-4 w-4 mt-[2px] text-brand-500 cursor-default"/>
        <PostDropown @click="dropDownEmit" :isPinned="_post.is_pinned"/>
      </div>
    </div>

    <!-- NOTE: POSTCARD CONTENTS -->
    <div ref="sentenceLines" class="m-1 bg-white px-4 py-2 rounded-lg mx-4 shadow">
      <div v-if="minimizeContent" v-html="quillContentToHtml(_post.content)" class="line-clamp-4" ></div>
      <div v-else v-html="quillContentToHtml(_post.content)"></div>
    </div>

    <button v-if="height > 95" class="mx-4 text-sm" @click="minimizeContent = !minimizeContent">{{ minimizeContent ? 'Show More...' : 'Show Less...'}}</button>

    <!-- NOTE: POSTCARD FOOTER -->
    <div class="flex justify-between mx-4 py-2 text-sm gap-4">
      <span class="text">😅</span>
      <span class="cursor-pointer">{{ contentFormatter('Comment', _post.comments_count) }}</span>
    </div>

    <!-- NOTE: COMMENTS -->
    <DataTransition class="mx-4 flex flex-col gap-2">
      <CommentContent v-for="comment in _post.comments" :key="comment.id" :comment :postId="_post.id"/>
    </DataTransition>

    <!-- NOTE: AUTH COMMENT -->
    <PostCommentCard :postId="_post.id" :groupId/>

  </div>
</template>

<script setup lang="ts">
import { ref, inject, onMounted, onUnmounted } from 'vue'
import { useElementSize } from '@vueuse/core'
import { TPost, TPostContent } from '@/globalTypes'
import { Quill } from '@vueup/vue-quill'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import { contentFormatter, dateTimeFormatted } from '@/converter'

import PostCommentCard from './PostCommentCard.vue'
import CommentContent from './CommentContent.vue'
import PostDropown from './PostDropown.vue'
import { MapPinIcon } from '@heroicons/vue/24/solid'

const $props = defineProps<{
  groupId: string
  post: TPost
  index: number
}>()
const $emits = defineEmits(['removePost'])
const _post = $props.post

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
      removePost(_post.id)
      break;
    case 'pin':
      pinPost(_post.id)
      break;
  }
}
// NOTE: Remove by [Auth]
function removePost(id: string) {
  axios.delete(`/dashboard/manage-posts/${id}?groupId=${$props.groupId}`)
}
// NOTE: Pin/Unpin By [admin/Mod]
function pinPost(id: string) {
  router.put(`/dashboard/manage-posts/${id}?redirect=/dashboard/manage-groups/${$props.groupId}/edit`,
    { type: 'pin' },
    { preserveScroll: true, preserveState: true }
  )
}

// NOTE: WS EVENTS
import Echo from 'laravel-echo'
import DataTransition from '../transitions/DataTransition.vue'
const echo = inject<Echo>('echo')

onMounted(async () => {
  echo?.channel(`post.${_post.id}`)
    .listen('PostEvent', (content: any) => {
      switch(content.type) {
        case 'comment':
          _post.comments = content.data
          _post.comments_count = content.data.length
          break;
        case 'post-delete':
          $emits('removePost', $props.index)
          break;
        case 'post-update':
          Object.assign(_post, {...content.data, ..._post.comments, ..._post.user})
          break;
      }
    })
})

onUnmounted(() => {
  echo?.leaveChannel(`post.${_post.id}`)
})
</script>
