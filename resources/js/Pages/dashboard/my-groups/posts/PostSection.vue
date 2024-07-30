<template>
  <div>
    <!-- NOTE: Create Post Card -->
    <BasicCard title="Create Post" :icon="ChatBubbleOvalLeftIcon" description="Creat Post to this group.">
      <div class="flex flex-wrap mt-4 gap-2">

        <AppButton
          name="Post Text"
          @click="AuthPostStore.open_modal_basic = true"
          :icon="ChatBubbleOvalLeftIcon"
          class="flex-grow flex-nowrap"
        >
          Text
        </AppButton>

        <AppButton
          name="Post Multimedia"
          @click="AuthPostStore.open_modal_multimedia = true"
          :icon="Square2StackIcon"
          class="flex-grow flex-nowrap"
        >
          Photos | Videos
        </AppButton>

        <AppButton
          name="Post Documents"
          @click="AuthPostStore.open_modal_documents = true"
          :icon="DocumentArrowUpIcon"
          class="flex-grow flex-nowrap"
        >
          Documents | Files
        </AppButton>

      </div>
    </BasicCard>

    <!-- SECTION: CREATE POST -->
    <!-- NOTE: TEXT -->
    <FormModal
      v-model="AuthPostStore.open_modal_basic"
      :title="AuthPostStore.selected_post_id == '' ? 'Create New Post' : 'Edit Post'"
      :description="AuthPostStore.selected_post_id == '' ? 'Create new post for this group.' : 'Edit post for this group.'"
      :icon="ChatBubbleOvalLeftIcon"
      size="max-w-lg"
    >
      <FlashErrors :errors="AuthPostStore.errors"/>

      <AppTextArea v-model="AuthPostStore.form.title" name="Title" noLabel lines="4"/>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="AuthPostStore.resetAllPostParameters()" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton
          v-if="AuthPostStore.selected_post_id == ''"
          name="Post"
          @click="AuthPostStore.submitBasicPost(handleScroll)"
          color="brand"
          :icon="PaperAirplaneIcon"
          :forceLoading="AuthPostStore.progress < 100"
        >
          Post
        </AppButton>

        <AppButton
          v-else
          name="Update"
          @click="AuthPostStore.updatePostApi()"
          color="brand"
          :icon="PaperAirplaneIcon"
          :forceLoading="AuthPostStore.progress < 100"
        >
          Update
        </AppButton>
      </div>

      <div v-if="AuthPostStore.progress > 0 && AuthPostStore.progress < 100" class="w-full bg-white rounded-full h-1.5 mt-4 mb-1">
        <div class="bg-brand-500 h-1.5 rounded-full transition-all" :style="`width: ${AuthPostStore.progress}%`"></div>
        <label class="text-sm justify-end flex text-brand-800">{{ AuthPostStore.progress }}%</label>
      </div>
    </FormModal>

    <!-- NOTE: MULTIMEDIA -->
    <FormModal
      v-model="AuthPostStore.open_modal_multimedia"
      title="Post Photos/Videos"
      description="Upload photos or videos for this post."
      :icon="Square2StackIcon"
      size="max-w-lg"
    >
      <FlashErrors :errors="AuthPostStore.errors"/>

      <AppTextArea v-model="AuthPostStore.form.title" name="Title" noLabel/>

      <div class="flex flex-col mt-4">
        <input
          @change="AuthPostStore.setToUploadFiles"
          type="file"
          name="file[]"
          multiple
          accept="image/png, image/gif, image/jpeg, video/mp4"
          class="placeholder-gray-50 block shadow w-full text-sm text-gray-900 cursor-pointer bg-white rounded-2xl focus:outline-none p-2"
        />
      </div>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="AuthPostStore.resetAllPostParameters()" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton
          name="Post"
          @click="AuthPostStore.submitMultimediaPost(handleScroll)"
          color="brand"
          :icon="PaperAirplaneIcon"
          :forceLoading="AuthPostStore.progress < 100"
        >
          Post
        </AppButton>
      </div>

      <div v-if="AuthPostStore.progress > 0 && AuthPostStore.progress < 100" class="w-full bg-white rounded-full h-1.5 mt-4 mb-1">
        <div class="bg-brand-500 h-1.5 rounded-full transition-all" :style="`width: ${AuthPostStore.progress}%`"></div>
        <label class="text-sm justify-end flex text-brand-800">{{ AuthPostStore.progress }}%</label>
      </div>

    </FormModal>

    <!-- NOTE: DOCUMENTS -->
    <FormModal
      v-model="AuthPostStore.open_modal_documents"
      title="Post Documents/Files"
      description="Upload documents or files for this post."
      :icon="DocumentArrowUpIcon"
      size="max-w-lg"
    >
      <FlashErrors :errors="AuthPostStore.errors"/>

      <AppTextArea v-model="AuthPostStore.form.title" name="Title" noLabel/>

      <div class="flex flex-col mt-4">
        <input
          @change="AuthPostStore.setToUploadFiles"
          type="file"
          name="file[]"
          multiple
          accept=".jpg, .png, .jpeg, .gif, .mp4, .doc, .docx, .pdf, .txt, .xlsx, .xls, .csv, .pptx, .ppt, .zip, .rar, application/msword"
          class="placeholder-gray-50 block shadow w-full text-sm text-gray-900 cursor-pointer bg-white rounded-2xl focus:outline-none p-2"
        />
      </div>

      <div class="flex justify-end mt-4 gap-2">
        <AppButton name="Post" @click="AuthPostStore.resetAllPostParameters()" :icon="XMarkIcon">Cancel</AppButton>
        <AppButton
          name="Post"
          @click="AuthPostStore.submitDocumentPost(handleScroll)"
          color="brand"
          :icon="PaperAirplaneIcon"
          :forceLoading="AuthPostStore.progress < 100"
        >
          Post
        </AppButton>
      </div>

      <div v-if="AuthPostStore.progress > 0 && AuthPostStore.progress < 100" class="w-full bg-white rounded-full h-1.5 mt-4 mb-1">
        <div class="bg-brand-500 h-1.5 rounded-full transition-all" :style="`width: ${AuthPostStore.progress}%`"></div>
        <label class="text-sm justify-end flex text-brand-800">{{ AuthPostStore.progress }}%</label>
      </div>
    </FormModal>

    <!-- SECTION: POSTS DATA -->
    <div ref="infiniteScroll">

      <DataTransition class="flex flex-col">
        <div v-for="post, index in AuthPostStore.post_data" :key="post.id" class="mt-4">
          <PostCard
            :post
            :index
          />
        </div>
      </DataTransition>
    </div>

    <!-- NOTE: Loading/No Data -->
    <div v-if="AuthPostStore.loading" class="bg-brand-50 sm:rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow mt-4">
      <ArrowPathIcon class="h-4 w-4 text-brand-600 animate-spin mr-2 mt-[5px]" />
      Loading...
    </div>
    <div v-if="AuthPostStore.last_page < AuthPostStore.page" class="bg-brand-50 sm:rounded-2xl p-4 text-center flex justify-center text-brand-600 transition-all shadow mt-4">
      <FaceSmileIcon class="h-4 w-4 text-brand-600 mr-2 mt-[5px]" />
      No post available. Have a good day!
    </div>

    <RemovalPrompt
      v-model="AuthPostStore.open_prompt_delete_post"
      title="Remove Post?"
      confirm="Yes! Remove this Post"
      @confirm="AuthPostStore.removePostApi()"
    >
      Do you want to remove this post?
    </RemovalPrompt>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useAuthPostStore } from '@/stores/AuthPostStore'
import { useReactionStore } from '@/stores/ReactionStore'

import PostCard from './PostCard.vue'
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
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'

const AuthPostStore = useAuthPostStore()
const ReactionStore = useReactionStore()
const infiniteScroll = ref<HTMLElement | null>(null)

function handleScroll() {
  let element = infiniteScroll.value
  if(element) {
    if(element?.getBoundingClientRect().bottom < window.innerHeight && !AuthPostStore.loading) {
      AuthPostStore.getMorePostApi(handleScroll)
    }
  }
}

onMounted(async () => {
  window.addEventListener('scroll', handleScroll)
  ReactionStore.getReactions()
  AuthPostStore.page = 1
  AuthPostStore.getMorePostApi(handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  ReactionStore.reaction_data = []
  AuthPostStore.post_data = []
})
</script>
