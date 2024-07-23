import { ref } from 'vue'
import { defineStore } from 'pinia'
import { Post } from '@/globalTypes'
import axios from 'axios'
import { useForm } from '@inertiajs/vue3'

export const usePostStore = defineStore('post', () => {
  const post_data = ref<Post[]>([])
  const loading = ref<boolean>(false)
  const progress = ref<number>(100)
  const page = ref<number>(1)
  const last_page = ref<number>(2)
  const errors = ref<string[]>([])
  const to_upload_files = ref([])
  const selected_post_id = ref<string>('')
  const selected_post_index = ref<number>(0)

  const open_modal_basic = ref<boolean>(false)
  const open_modal_multimedia = ref<boolean>(false)
  const open_modal_documents = ref<boolean>(false)
  const open_prompt_delete_post = ref<boolean>(false)

  const form = useForm<{title: string}>({
    title: ''
  })

  function selectPost(value: {id: string, index: number, title: string}) {
    form.title = value.title
    selected_post_id.value = value.id
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
    // @ts-ignore
    to_upload_files.value = event.target.files
  }

  // SECTION: GET POSTS
  async function getMorePostApi(group_id: string, handleScroll: () => void) {
    if (loading.value == true)
      return true

    loading.value = true

    if(page.value <= last_page.value) {
      const res = await axios.get(
        route('dashboard.posts.index', { page: page.value, group_id: group_id })
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
  async function submitBasicPost(group_id: string, handleScroll: () => void) {
    progress.value = 0
    // NOTE: Create Post
    try {
      await axios.post(route('dashboard.posts.store'), {
        title: form.title,
        group_id: group_id,
        type: 'basic',
      })
      resetAllPostParameters()
      resetPostData()
      getMorePostApi(group_id, handleScroll)
    }
    catch(err) {
      // @ts-ignore
      errors.value = err.response.data.errors
      progress.value = 100
    }
  }

  // NOTE: Multimedia Post
  async function submitMultimediaPost(group_id: string, handleScroll: () => void) {
    progress.value = 0
    const formData = new FormData()
    // @ts-ignore
    for(let i = 0; i < to_upload_files.value.length; i++) {
      formData.append(`files[${i}]`, to_upload_files.value[i])
    }
    formData.append('title', form.title)
    formData.append('group_id', group_id)
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
      getMorePostApi(group_id, handleScroll)
    }
    catch(err) {
      // @ts-ignore
      alert(JSON.stringify(err))
      // errors.value = err.response.data.errors
      progress.value = 100
    }
  }

  // NOTE: Document Post
  async function submitDocumentPost(group_id: string, handleScroll: () => void) {
    progress.value = 0
    const formData = new FormData()
    // @ts-ignore
    for(let i = 0; i < to_upload_files.value.length; i++) {
      formData.append(`files[${i}]`, to_upload_files.value[i])
    }
    formData.append('title', form.title)
    formData.append('group_id', group_id)
    formData.append('type', 'documents')

    try {
      const res = await axios.post(`/dashboard/posts`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        onUploadProgress: (progress_event: any) => {
          progress.value = Math.round((progress_event.loaded / progress_event.total) * 100)
        }
      })
      resetAllPostParameters()
      resetPostData()
      getMorePostApi(group_id, handleScroll)
    }
    catch(err) {
      // @ts-ignore
      errors.value = err.response.data.errors

      progress.value = 100
    }
  }

  // SECTION: UPDATE POST
  // NOTE: Pin post
  async function pinPostApi(post_id: string, is_pinned: number) {
    await axios.put(`/dashboard/posts/${post_id}/pin`, { is_pinned })
    const updated_post = post_data.value.find((post: Post) => post.id === post_id)!
    updated_post.is_pinned = is_pinned
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
    pinPostApi
  }
})
