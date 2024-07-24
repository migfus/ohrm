<template>
  <div>
    <DataTransition v-if="comments.length > 0" class="mx-4 flex flex-col gap-2 bg-white rounded-2xl p-2">
      <CommentContent
        v-for="comment, index in comments"
        :key="comment.id"
        :comment
        :post_id
        :index
        @removeComment="removeComment"
        @updateComment="updateComment"
      />
    </DataTransition>

    <!-- NOTE: AUTH COMMENT -->
    <AuthComment :post_id @submitNewComment="submitNewComment"/>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Comment } from '@/globalTypes'
import { useCommentStore } from '@/stores/CommentStore'

import DataTransition from '@/components/transitions/DataTransition.vue'

import CommentContent from './CommentContent.vue'
import AuthComment from './AuthComment.vue'

const $props = defineProps<{
  comments: Comment[]
  post_id: string
  comments_count: number
}>()
const CommentStore = useCommentStore()

const comments = ref<Comment[]>($props.comments) // allows changable comments
const comments_count = ref($props.comments_count)

async function submitNewComment(content: string) {
  let new_comment_data = await CommentStore.newCommentApi($props.post_id, content)
  comments.value = [new_comment_data, ...comments.value]
  comments_count.value++
}

async function removeComment(index: number, comment_id: string) {
  await CommentStore.removeCommentApi(comment_id)
  comments.value.splice(index, 1)
  comments_count.value--
}

async function updateComment(index: number, comment_id: string, content: string) {
  // await CommentStore.removeCommentApi(comment_id)
  comments.value[index].content = content
}
</script>
