import { ref } from 'vue'
import { defineStore } from 'pinia'
import { Post } from '@/globalTypes'
import axios from 'axios'
import { useForm } from '@inertiajs/vue3'
import { usePinnedPostStore } from './PinnedPostStore'

export const useAuthPostStore = defineStore('auth-post', () => {
  const PinnedPostStore = usePinnedPostStore()

  const post_data = ref<Post[]>([])
  const loading = ref<boolean>(false)
  const progress = ref<number>(100)
  const page = ref<number>(1)
  const last_page = ref<number>(2)
  const errors = ref<string[]>([])
  const to_upload_files = ref<FileList | null>(null)
  const selected_post_id = ref<string>('')
  const selected_post_index = ref<number>(0)

  const open_modal_basic = ref<boolean>(false)
  const open_modal_multimedia = ref<boolean>(false)
  const open_modal_documents = ref<boolean>(false)
  const open_prompt_delete_post = ref<boolean>(false)

  const form = useForm<{title: string}>({
    title: ''
  })

  function selectPost(post_id: string) {
    post_data.value.find((post: Post) => {
      if(post.id === post_id) {
        form.title = post.title
        selected_post_id.value = post.id
        open_modal_basic.value = true
      }
    })
  }

  function updatePostData(dat: { index: number; updated_post: Post}) {
    post_data.value[dat.index] = dat.updated_post
  }

  function attemptRemovePost(post_id: string, index: number) {
    selected_post_id.value = post_id
    selected_post_index.value = index
    open_prompt_delete_post.value = true
  }

  function setToUploadFiles(event: Event) {
    const _target = event.target as HTMLInputElement
    to_upload_files.value = _target.files
  }

  // SECTION: GET POSTS
  async function getMorePostApi(handleScroll: () => void) {
    if (loading.value == true)
      return true

    loading.value = true

    if(page.value <= last_page.value) {
      const res = await axios.get(
        route('dashboard.auth-posts.index', { page: page.value })
      )
      post_data.value = [...post_data.value, ...res.data.data]
      last_page.value = res.data.last_page
      loading.value = false
    }
    else {
      window.removeEventListener('scroll', handleScroll)
      loading.value = false
    }

    page.value++
  }

  // SECTION: CREATE POST
  // NOTE: Basic Post
  async function submitBasicPost(handleScroll: () => void) {
    progress.value = 0
    // NOTE: Create Post
    try {
      await axios.post(route('dashboard.posts.store'), {
        title: form.title,
        type: 'basic',
      })
      resetAllPostParameters()
      resetPostData()
      getMorePostApi(handleScroll)
    }
    catch(err: any) {
      errors.value = err.response.data.errors
      progress.value = 100
    }
  }

  // NOTE: Multimedia Post
  async function submitMultimediaPost(handleScroll: () => void) {
    progress.value = 0
    const formData = new FormData()
    if(to_upload_files.value) {
      for(let i = 0; i < to_upload_files.value.length; i++) {
        formData.append(`files[${i}]`, to_upload_files.value[i])
      }
    }

    formData.append('title', form.title)
    formData.append('type', 'multimedia')

    try {
      await axios.post(route('dashboard.posts.store'), formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        onUploadProgress: (progress_event: any) => {
          progress.value = Math.round((progress_event.loaded / progress_event.total) * 100)
        }
      })
      resetAllPostParameters()
      resetPostData()
      getMorePostApi(handleScroll)
    }
    catch(err) {
      // @ts-ignore
      alert(JSON.stringify(err))
      // errors.value = err.response.data.errors
      progress.value = 100
    }
  }

  // NOTE: Document Post
  async function submitDocumentPost(handleScroll: () => void) {
    progress.value = 0
    const formData = new FormData()
    if(to_upload_files.value) {
      for(let i = 0; i < to_upload_files.value.length; i++) {
        formData.append(`files[${i}]`, to_upload_files.value[i])
      }
    }
    formData.append('title', form.title)
    formData.append('type', 'documents')

    try {
      await axios.post(`/dashboard/posts`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        onUploadProgress: (progress_event: any) => {
          progress.value = Math.round((progress_event.loaded / progress_event.total) * 100)
        }
      })
      resetAllPostParameters()
      resetPostData()
      getMorePostApi(handleScroll)
    }
    catch(err: any) {
      errors.value = err.response.data.errors

      progress.value = 100
    }
  }

  // SECTION: UPDATE POST
  // NOTE: Pin post
  async function pinPostApi(post_id: string, group_id = '[no group_id]') {
    await axios.put(route('dashboard.posts.update', {post: post_id}), { type: 'pin' })
    post_data.value.find((post: Post) => {
      if(post.id === post_id) {
        if(post.is_pinned === 0)
          post.is_pinned = 1
        else
          post.is_pinned = 0
      }
    })

    PinnedPostStore.getPinnedPosts(group_id)
  }
  // NOTE: Update Post
  async function updatePostApi() {
    post_data.value.find((post: Post) => {
      if(post.id === selected_post_id.value) {
        post.title = form.title
      }
    })

    await axios.put(
      route('dashboard.posts.update',
      { post: selected_post_id.value }), { title: form.title, type: 'title' }
    )
    resetAllPostParameters()
  }

  // SECTION: REMOVE
  async function removePostApi() {
    await axios.delete(route('dashboard.posts.destroy', { post: selected_post_id.value}))
    post_data.value.splice(selected_post_index.value, 1)

    selected_post_id.value = ''
    selected_post_index.value = 0
  }

  // SECTION RESET
  function resetAllPostParameters() {
    form.reset()
    selected_post_id.value = ''
    selected_post_index.value = 0
    progress.value = 100

    open_modal_basic.value = false
    open_modal_multimedia.value = false
    open_modal_documents.value = false
    errors.value = []
  }

  function resetPostData() {
    page.value = 1
    post_data.value = []
  }

  return {
    post_data,
    loading,
    progress,
    page,
    last_page,
    errors,
    form,
    to_upload_files,
    selected_post_id,

    open_modal_basic,
    open_modal_multimedia,
    open_modal_documents,
    open_prompt_delete_post,

    getMorePostApi,
    removePostApi,
    selectPost,
    resetAllPostParameters,
    submitBasicPost,
    submitMultimediaPost,
    submitDocumentPost,
    setToUploadFiles,
    updatePostData,
    attemptRemovePost,
    pinPostApi,
    updatePostApi,
  }
})
