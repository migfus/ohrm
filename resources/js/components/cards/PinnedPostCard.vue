<template>
  <div class="bg-white shadow sm:rounded-2xl text-brand-800">

    <div class="flex font-medium justify-between px-4 pt-4 pb-2">
      <Link :href="`/dashboard/manage-users/${post.user.id}/edit`" class="flex">
        <img :src="post.user.avatar" class="h-8 w-8 rounded-full shadow mr-2" />
        <div class="flex flex-col">
          <span class="text-sm">{{ post.user.name }}</span>
          <span class="text-xs">{{ moment(post.created_at).fromNow(true) }}</span>
        </div>
      </Link>
      <div class="text-sm font-regular py-0 my-0 cursor-pointer" @click="unpinPost()">
        <XMarkIcon class="h-4 w-4"/>
      </div>
    </div>

    <div v-html="quillContentToHtml(post.content)" class="m-1 bg-white px-4 py-2 rounded-lg"></div>

    <div class="flex justify-between mx-4 py-2 text-sm gap-4">
      <span class="text">😅</span>
      <span>
        <span class="inline">0</span>
        <ChatBubbleLeftRightIcon class="w-4 h-4 inline ml-1 text-brand-500"/>
      </span>
    </div>

  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { TPost, TPostContent } from '@/globalTypes'
import { Quill } from '@vueup/vue-quill'
import moment from 'moment'

import { XMarkIcon, ChatBubbleLeftRightIcon } from '@heroicons/vue/24/solid'

const $props = defineProps<{
  post: TPost
  groupId: string
}>()

function quillContentToHtml(content: TPostContent[]) {
  if(content && typeof content === 'object') {
    const quill = new Quill(document.createElement('div'))
    quill.setContents(
      content.filter(r => r.insert == null ? false : true)
    )
    return quill.root.innerHTML
  }
  return content
}

function unpinPost() {
  router.put(`/dashboard/manage-posts/${$props.post.id}?redirect=/dashboard/manage-groups/${$props.groupId}/edit`,
    { type: 'pin' },
    { preserveScroll: true, preserveState: true }
  )
}
</script>
