<template>
  <div class="flex gap-2">
    <img :src="comment.user?.avatar" class="h-5 w-5 rounded-full mt-2"/>
    <div class="bg-brand-50 shadow rounded-2xl px-3 py-2 text-xs flex flex-col flex-grow">
      <div class="flex justify-between">
        <label class="font-medium">{{ comment.user?.name }} - {{ dateTimeFormatted(comment.created_at) }}</label>
        <CommentDropdown @click="dropdownSelection" :user_id="$props.comment.user_id"/>
      </div>

      <label class="text-sm">{{ comment.content }}</label>
    </div>
  </div>
</template>

<script setup lang="ts">
import { dateTimeFormatted } from '@/converter'
import { Comment } from '@/globalTypes'

import CommentDropdown from '@/components/dropdowns/CommentDropdown.vue'

const $props = defineProps<{
  comment: Comment
  postId: string
  index: number
}>()

const $emit = defineEmits(['removeComment', 'updateComment'])

function dropdownSelection(val: string) {
  switch(val) {
    case 'delete':
      $emit('removeComment', $props.index, $props.comment.id); break
    default:
      $emit('updateComment', $props.index, $props.comment.id, ); break
  }
}
</script>
