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

      <AppTextArea v-model:content="form.content" name="Content" noLabel lines="4"/>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="open_create_text_post_modal = false" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton name="Post" @click="submitPost()" color="brand" :icon="PaperAirplaneIcon">Post</AppButton>
      </div>
    </FormModal>

    <!-- NOTE: PHOTOS -->
    <FormModal
      v-model="open_create_photos_post_modal"
      title="Post Photos/Videos"
      description="Upload photos or videos for this post."
      :icon="Square2StackIcon"
      size="max-w-lg"
    >

      <AppTextArea v-model:content="form.content" name="Content" noLabel/>

      <div class="flex flex-col mt-4">
        <input
          type="file"
          name="files"
          multiple
          accept="image/png, image/gif, image/jpeg"
          class="placeholder-gray-50 block shadow w-full text-sm text-gray-900 cursor-pointer bg-white rounded-2xl focus:outline-none p-2"
        />
      </div>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="open_create_photos_post_modal = false" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton name="Post" @click="submitPost()" color="brand" :icon="PaperAirplaneIcon">Post</AppButton>
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

      <AppTextArea v-model:content="form.content" name="Content" noLabel/>

      <div class="flex flex-col mt-4">
        <input
          type="file"
          name="files"
          multiple
          accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*"
          class="placeholder-gray-50 block shadow w-full text-sm text-gray-900 cursor-pointer bg-white rounded-2xl focus:outline-none p-2"
        />
      </div>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="open_create_documents_post_modal = false" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton name="Post" @click="submitPost()" color="brand" :icon="PaperAirplaneIcon">Post</AppButton>
      </div>
    </FormModal>

    <!-- NOTE: POSTS DATA -->
    <div ref="infiniteScroll" class="mt-4">
      <DataTransition class="flex flex-col gap-4">
        <div v-for="post, index in posts" :key="post.id">
          <PostCard
            :post
            :index
            :groupId
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
import { Post } from '@/globalTypes'
import { router } from '@inertiajs/vue3'
import Echo from 'laravel-echo'
import axios from 'axios'

import PostCard from '@/components/cards/PostCard.vue'
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

const $props = defineProps<{
  groupId: string
}>()

// NOTE: POSTS
const posts = ref<Post[]>([])
const page = ref(0)
const lastPage = ref<number>(2)
const infiniteScroll = ref<HTMLElement | null>(null)
const loading = ref(false)
const echo = inject<Echo>('echo')
const editPostId = ref<string>('')
const editPostIndex = ref<number>(0)

async function getMorePosts() {
  page.value++
  loading.value = true

  if(page.value <= lastPage.value) {
    const res = await axios.get(`/dashboard/manage-posts?page=${page.value}&groupId=${$props.groupId}`)
    posts.value = [...posts.value,...res.data.data]
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

function removePost(index: number) {
  posts.value.splice(index, 1)
}
function updatedPost(dat: { index: number; data: Post}) {
  posts.value[dat.index] = dat.data
}

// SECTION: CREATE POST
const open_create_text_post_modal = ref(false)
const open_create_photos_post_modal = ref(false)
const open_create_documents_post_modal = ref(false)

const toolbar = {
  container: [
    ['bold', 'italic', 'underline','strike', 'blockquote'],
    [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
    ['link', 'image', 'video'],
    ['clean']
  ]
}

const form = router.form<{content: {ops: string}}>({
  content: { ops: '' }
})

async function submitPost() {
  // NOTE: Create Post
  if(editPostId.value == '') {
    const res = await axios.post(`/dashboard/manage-posts`, {
      content: form.content.ops,
      groupId: $props.groupId
    })
    posts.value = [res.data, ...posts.value, ]
  }
  // NOTE: Update Post
  else {
    const res = await axios.put(`/dashboard/manage-posts/${editPostId.value}`, {
      content: form.content,
      type: 'update-content'
    })
    posts.value[editPostIndex.value] = res.data
  }

  editPostId.value = ''
  editPostIndex.value = 0
  open_create_documents_post_modal.value = false
  open_create_photos_post_modal.value = false
  form.reset()
}

function editPost(value: {id: string, index: number, content: string}) {
  form.content = JSON.parse(value.content)
  editPostId.value = value.id
}
</script>

<style>
.ql-toolbar{
  background-color: #fff !important;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
  box-shadow: #000;
}
.ql-container {
  background-color: #fff !important;
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
}
.ql-container.ql-snow {
  border: 0px solid #fff !important;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}
.ql-toolbar.ql-snow  {
  border: 0px 0px 1px 0px solid #818181 !important;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}
.ql-editor {
  min-height: 100px !important;
}
</style>
