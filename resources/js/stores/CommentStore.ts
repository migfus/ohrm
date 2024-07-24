import { defineStore } from "pinia"
import axios from "axios"
import { Comment } from "@/globalTypes"

export const useCommentStore = defineStore('commentStore', () => {
  async function newCommentApi(post_id: string, content: string) {
    const res = await axios.post(route('dashboard.comments.store'), {
      post_id,
      content,
    })
    return res.data as Comment
  }

  async function removeCommentApi(comment_id: string) {
    await axios.delete(route('dashboard.comments.destroy', { comment: comment_id }))
  }

  function reportComment() {
    alert('[reported]')
  }

  return {
    newCommentApi,
    removeCommentApi,
    reportComment
  }
})
