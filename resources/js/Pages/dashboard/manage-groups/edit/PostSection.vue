<template>
  <div>
    <!-- NOTE: Create Post Card -->
    <BasicCard title="Create Post" :icon="ChatBubbleOvalLeftIcon" description="Creat Post to this group.">
      <div class="flex mt-4 gap-2">
        <AppButton name="Post" :icon="ChatBubbleOvalLeftIcon" @click="open_create_text_post_modal = true" class="flex-grow flex-nowrap">Text</AppButton>
        <AppButton name="Post" @click="open_create_photos_post_modal = true" :icon="Square2StackIcon" class="flex-grow flex-nowrap">Photos | Videos</AppButton>
        <AppButton name="Post" @click="open_create_documents_post_modal = true" :icon="DocumentArrowUpIcon" class="flex-grow flex-nowrap">Documents | Files</AppButton>
      </div>
    </BasicCard>

    <!-- SECTION: CREATE POST -->
    <!-- NOTE: TEXT -->
    <FormModal
      v-model="open_create_text_post_modal"
      title="Create New Post"
      description="Create new post for this group."
      :icon="ChatBubbleOvalLeftIcon"
      size="max-w-lg"
    >
      <FlashErrors :errors/>

      <AppTextArea v-model="form.title" name="Title" noLabel lines="4"/>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="resetAll()" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton name="Post" @click="submitBasicPost()" color="brand" :icon="PaperAirplaneIcon" :forceLoading="uploadLoading">Post</AppButton>
      </div>
    </FormModal>

    <!-- NOTE: MULTIMEDIA -->
    <FormModal
      v-model="open_create_photos_post_modal"
      title="Post Photos/Videos"
      description="Upload photos or videos for this post."
      :icon="Square2StackIcon"
      size="max-w-lg"
    >
      <FlashErrors :errors/>

      <AppTextArea v-model="form.title" name="Title" noLabel/>

      <div class="flex flex-col mt-4">
        <input
          @change="setFiles"
          type="file"
          name="file[]"
          multiple
          accept="image/png, image/gif, image/jpeg, video/mp4"
          class="placeholder-gray-50 block shadow w-full text-sm text-gray-900 cursor-pointer bg-white rounded-2xl focus:outline-none p-2"
        />
      </div>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="resetAll()" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton name="Post" @click="submitMultimediaPost()" color="brand" :icon="PaperAirplaneIcon" :forceLoading="uploadLoading">Post</AppButton>
      </div>

      <div v-if="progress > 0" class="w-full bg-white rounded-full h-1.5 mt-4">
        <div class="bg-brand-500 h-1.5 rounded-full transition-all" :style="`width: ${progress*10}%`"></div>
      </div>

    </FormModal>

    <!-- NOTE: DOCUMENTS -->
    <FormModal
      v-model="open_create_documents_post_modal"
      title="Post Documents/Files"
      description="Upload documents or files for this post."
      :icon="DocumentArrowUpIcon"
      size="max-w-lg"
    >
      <FlashErrors :errors/>

      <AppTextArea v-model="form.title" name="Title" noLabel/>

      <div class="flex flex-col mt-4">
        <input
          @change="setFiles"
          type="file"
          name="file[]"
          multiple
          accept=".jpg, .png, .jpeg, .gif, .mp4, .doc, .docx, .pdf, .txt, .xlsx, .xls, .csv, .pptx, .ppt, .zip, .rar, application/msword"
          class="placeholder-gray-50 block shadow w-full text-sm text-gray-900 cursor-pointer bg-white rounded-2xl focus:outline-none p-2"
        />
      </div>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="resetAll()" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton name="Post" @click="submitDocumentPost()" color="brand" :icon="PaperAirplaneIcon">Post</AppButton>
      </div>

      <div v-if="progress > 0" class="w-full bg-white rounded-full h-1.5 mt-4">
        <div class="bg-brand-500 h-1.5 rounded-full transition-all" :style="`width: ${progress*10}%`"></div>
      </div>
    </FormModal>

    <!-- SECTION: POSTS DATA -->
    <div ref="infiniteScroll" class="mt-4">
      <DataTransition class="flex flex-col gap-4">
        <div v-for="post, index in posts" :key="post.id">
          <PostCard
            :post
            :index
            :groupId
            :reactions
            @removePost="removePost"
            @updatedPost="updatedPost"
            @editPost="editPost"
          />
        </div>
      </DataTransition>
    </div>

    <!-- NOTE: Loading/No Data -->
    <div v-if="loading" class="bg-brand-50 rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow mt-4">
      <ArrowPathIcon class="h-4 w-4 text-brand-600 animate-spin mr-2 mt-[5px]" />
      Loading...
    </div>
    <div v-if="lastPage < page" class="bg-brand-50 rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow mt-4">
      <FaceSmileIcon class="h-4 w-4 text-brand-600 mr-2 mt-[5px]" />
      No post available. Have a good day!
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, inject } from 'vue'
import { Post, Reaction } from '@/globalTypes'
import { router } from '@inertiajs/vue3'
import Echo from 'laravel-echo'
import axios from 'axios'

import PostCard from '@/components/cards/posts/PostCard.vue'
import BasicCard from '@/components/cards/BasicCard.vue'
import {
  ArrowPathIcon,
  FaceSmileIcon,
  ChatBubbleOvalLeftIcon,
  XMarkIcon,
  PaperAirplaneIcon,
  Square2StackIcon,
  DocumentArrowUpIcon,
} from '@heroicons/vue/24/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'
import FormModal from '@/components/modals/FormModal.vue'
import AppButton from '@/components/form/AppButton.vue'
import AppTextArea from '@/components/form/AppTextArea.vue'
import FlashErrors from '@/components/headers/FlashErrors.vue'

const $props = defineProps<{
  groupId: string
}>()

const loading = ref(false)
const uploadLoading = ref(false)
const echo = inject<Echo>('echo')
const posts = ref<Post[]>([])
const reactions = ref<Reaction[]>([])
const page = ref(0)
const lastPage = ref<number>(2)
const infiniteScroll = ref<HTMLElement | null>(null)
const set_files = ref([])
const errors = ref<object>({})
const progress = ref<number>(0)

async function getReactions() {
  const res = await axios.get(route('dashboard.reactions.index'))
  reactions.value = res.data
}

async function getMorePosts() {
  page.value++
  loading.value = true

  if(page.value <= lastPage.value) {
    const res = await axios.get(`/dashboard/posts?page=${page.value}&group_id=${$props.groupId}`)
    posts.value = [...posts.value, ...res.data.data]
    lastPage.value = res.data.last_page
    loading.value = false
  }
  else {
    window.removeEventListener('scroll', handleScroll)
    loading.value = false
  }
}

onMounted(async () => {
  window.addEventListener('scroll', handleScroll)

  echo?.channel(`posts`)
  .listen('PostsEvent', () => {
    // alert('event new posts added')
  })

  getReactions()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  echo?.leaveChannel(`posts`)
})

const handleScroll = () => {
  let element = infiniteScroll.value
  if(element) {
    if(element?.getBoundingClientRect().bottom < window.innerHeight && !loading.value) {
      loadMore()
    }
  }
}

async function loadMore() {
  if(loading.value) return
  await getMorePosts()
}

// NOTE: REMOVE
function removePost(index: number) {
  posts.value.splice(index, 1)
}

// NOTE: UPDATE
const editPostId = ref<string>('')
const editPostIndex = ref<number>(0)

function updatedPost(dat: { index: number; data: Post}) {
  posts.value[dat.index] = dat.data
}

// SECTION: CREATE POST
const open_create_text_post_modal = ref(false)
const open_create_photos_post_modal = ref(false)
const open_create_documents_post_modal = ref(false)

const form = router.form<{title: string}>({
  title: ''
})

function setFiles(event: Event) {
  // @ts-ignore
  set_files.value = event.target.files
}

async function submitBasicPost() {
  uploadLoading.value = true
  // NOTE: Create Post
  try {
    const res = await axios.post(`/dashboard/posts`, {
      title: form.title,
      group_id: $props.groupId,
      type: 'basic',
    })
    posts.value = [res.data, ...posts.value, ]
    resetAll()
    uploadLoading.value = false
    page.value = 1
    getMorePosts()
  }
  catch(err) {
    // @ts-ignore
    errors.value = err.response.data.errors

    uploadLoading.value = false
  }
}

async function submitMultimediaPost() {
  uploadLoading.value = true
  const formData = new FormData()
  // @ts-ignore
  for(let i = 0; i < set_files.value.length; i++) {
    formData.append(`files[${i}]`, set_files.value[i])
  }
  formData.append('title', form.title)
  formData.append('group_id', $props.groupId)
  formData.append('type', 'multimedia')

  try {
    const res = await axios.post(`/dashboard/posts`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onUploadProgress: (progress_event: any) => {
        progress.value = Math.round((progress_event.loaded / progress_event.total) * 10)
      }
    })
    posts.value = [res.data, ...posts.value, ]
    uploadLoading.value = false
    resetAll()
    page.value = 0
    posts.value = []
    getMorePosts()
  }
  catch(err) {
    // @ts-ignore
    errors.value = err.response.data.errors

    uploadLoading.value = false
  }
}

async function submitDocumentPost() {
  uploadLoading.value = true
  const formData = new FormData()
  // @ts-ignore
  for(let i = 0; i < set_files.value.length; i++) {
    formData.append(`files[${i}]`, set_files.value[i])
  }
  formData.append('title', form.title)
  formData.append('group_id', $props.groupId)
  formData.append('type', 'documents')

  try {
    const res = await axios.post(`/dashboard/posts`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onUploadProgress: (progress_event: any) => {
        progress.value = Math.round((progress_event.loaded / progress_event.total) * 10)
      }
    })
    posts.value = [res.data, ...posts.value, ]
    uploadLoading.value = false
    resetAll()
    page.value = 0
    posts.value = []
    getMorePosts()
  }
  catch(err) {
    // @ts-ignore
    errors.value = err.response.data.errors

    uploadLoading.value = false
  }
}

function editPost(value: {id: string, index: number, title: string}) {
  form.title = JSON.parse(value.title)
  editPostId.value = value.id
}

function resetAll() {
  progress.value = 0

  form.reset()

  editPostId.value = ''
  editPostIndex.value = 0

  open_create_text_post_modal.value = false
  open_create_documents_post_modal.value = false
  open_create_photos_post_modal.value = false
}
</script>
