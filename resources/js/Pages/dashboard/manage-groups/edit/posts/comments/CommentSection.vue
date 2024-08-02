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

      <!-- NOTE: GET MORE COMMENTS -->
      <div
        v-if="loadComments"
        class="text-right text-sm text-brand-400 my-1"
      >
        Loading...
      </div>
      <button
        v-else-if="comments_count_model > (3 * page)"
        class="text-right text-sm text-brand-400 my-1"
        @click="loadMoreComments"
      >
        Load More Comments ({{ comments_count_model - (3 * page)}})
      </button>

    </DataTransition>

    <!-- NOTE: AUTH COMMENT -->
    <AuthComment
      :post_id
      v-model="form.content"
      v-model:lines="lines"
      @submitComment="submitComment"
      @resetForm="form.reset()"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, onErrorCaptured } from 'vue'
import { Comment } from '@/globalTypes'
import { useCommentStore } from '@/stores/CommentStore'
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'
import { errorAlert } from '@/converter'

import DataTransition from '@/components/transitions/DataTransition.vue'
import CommentContent from './CommentContent.vue'
import AuthComment from './AuthComment.vue'

const $props = defineProps<{
  comments: Comment[]
  post_id: string
  group_id: string
}>()
const comments_count_model = defineModel<number>({default: 0})
const $emit = defineEmits(['commentsCountChange'])
const CommentStore = useCommentStore()

const comments = ref<Comment[]>($props.comments) // allows changable comments
const form = useForm({
  content: '',
})
const lines = ref(1)
const page = ref(1)
const loadComments = ref<boolean>(false)

async function submitComment() {
  // NOTE: NEW COMMENT
  if(CommentStore.select_comment_id == '') {
    let new_comment_data = await CommentStore.newCommentApi($props.post_id, form.content, $props.group_id)
    console.log(new_comment_data)
    comments.value = [new_comment_data, ...comments.value]
    if(comments_count_model.value === undefined)
      comments_count_model.value = 1
    else
      comments_count_model.value++
  }
  // NOTE: UPDATE COMMENT
  else {
    await CommentStore.updatCommentApi(CommentStore.select_comment_id, form.content, $props.group_id)
    comments.value[CommentStore.select_index].content = form.content
  }

  CommentStore.select_comment_id = ''
  CommentStore.select_index = -1

  form.reset()
}

async function removeComment(index: number, comment_id: string) {
  await CommentStore.removeCommentApi(comment_id)
  comments.value.splice(index, 1)
  if(comments_count_model.value === undefined)
    comments_count_model.value = 0
  else
    comments_count_model.value--
}

async function updateComment(index: number, comment_id: string, content: string) {
  form.content = comments.value[index].content
  CommentStore.select_index = index
  CommentStore.select_comment_id = comment_id
  lines.value = 2
}

async function loadMoreComments() {
  loadComments.value = true
  page.value++
  const res = await axios.get(route('dashboard.comments.index',
    { page: page.value, post_id: $props.post_id, group_id: $props.group_id })
  )
  comments.value = [...comments.value,...res.data.data]
  loadComments.value = false
}

onErrorCaptured((e) => errorAlert('/dashboard/manage-groups/edit/posts/comments/CommentSection', e))
</script>
