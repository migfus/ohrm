<template>
  <div class="flex gap-2 ">
    <img :src="comment.user.avatar" class="h-4 w-4 rounded-full"/>
    <div class="bg-brand-50 shadow rounded-2xl px-3 py-2 text-xs flex flex-col flex-grow">
      <div class="flex justify-between">
        <label class="font-medium">{{ comment.user.name }} - {{ dateTimeFormatted(comment.created_at) }}</label>
        <PostCommentDropdown @click="dropdownSelection"/>
      </div>

      <label class="text-sm">{{ comment.content }}</label>
    </div>
  </div>
</template>

<script setup lang="ts">
import { dateTimeFormatted } from '@/converter'
import { Comment } from '@/globalTypes'
import axios from 'axios'

import PostCommentDropdown from '@/components/dropdowns/CommentDropdown.vue'

const $props = defineProps<{
  comment: Comment
  postId: string
}>()

function dropdownSelection(val: string) {
  switch(val) {
    case 'delete':
      removeCommentApi(); break
  }
}

async function removeCommentApi() {
  await axios.delete(`/dashboard/manage-comments/${$props.comment.id}?postId=${$props.postId}`)
}
</script>
