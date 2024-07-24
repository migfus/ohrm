import SharedProps from "@/SharedProps"
import { useForm, usePage } from "@inertiajs/vue3"
import { defineStore } from "pinia"

export const useCommentStore = defineStore('commentStore', () => {
  const page = usePage<SharedProps>()

  const form = useForm({
    title: ''
  })

  function addComment() {
    return {
      title: form.title,
      user: page.props.auth,
      created_at: new Date().toISOString(),
    }
  }


  return {
    form,
    addComment
  }
})
