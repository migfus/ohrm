import { defineStore } from "pinia"
import axios from "axios"
import { Comment } from "@/globalTypes"
import { ref } from "vue"

export const useCommentStore = defineStore('commentStore', () => {
  const select_comment_id = ref<string>('')
  const select_index = ref<number>(-1)

  async function newCommentApi(post_id: string, content: string, group_id: string) {
    const res = await axios.post(route('dashboard.comments.store'), {
      post_id,
      content,
      group_id
    })
    return res.data as Comment
  }

  async function removeCommentApi(comment_id: string) {
    await axios.delete(route('dashboard.comments.destroy', { comment: comment_id }))
  }

  async function updatCommentApi(comment_id: string, content: string, group_id: string) {
    await axios.put(route('dashboard.comments.update', { comment: comment_id }),
      { content, group_id }
    )
  }

  function reportComment() {
    alert('[reported]')
  }

  return {
    select_comment_id,
    select_index,

    newCommentApi,
    removeCommentApi,
    reportComment,
    updatCommentApi
  }
})
