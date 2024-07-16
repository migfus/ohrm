<template>
  <!-- SECTION: POST PREVIEW -->
  <!-- NOTE: 4 & below PREVIEW -->
  <DataTransition v-if="counts < 4" class="flex my-4 gap-2">
    <div v-for="block in contents">
      <img :src="block.thumbnail_url" alt="post image"  class="aspect-square object-cover rounded-2xl"/>
    </div>
  </DataTransition>

  <!-- NOTE: 5+ PREVIEW -->
  <DataTransition v-else class="grid grid-cols-2 my-4 gap-1">
    <div v-for="block, idx in contents.slice(0,4)" class="relative cursor-pointer" @click="openPreview(block, idx)">
      <div v-if="idx > 2 && counts > 4" class="overflow-hidden w-full rounded-lg flex bg-gray-600/75 shadow h-full" >
        <div class="m-auto text-2xl text-white">+ {{ counts - 4 }}</div>
        <img :src="block.thumbnail_url" class="blur-lg absolute aspect-square opacity-25">
      </div>
      <div v-else >
        <img :src="block.thumbnail_url" alt="post image" class="aspect-square object-cover rounded-lg" />
      </div>
    </div>
  </DataTransition>
  <!-- <div class="flex justify-end">
    <AppButton :icon="ArrowDownIcon" name="Download All" color="brand" size="sm">Download All</AppButton>
  </div> -->


  <!-- SECTION: MODAL VIEW -->
  <MultimediaViewModal v-model="open_preview_modal" :user :createdAt >
    <div class="bg-white p-4 rounded-2xl shadow" @keyup.left="navLeft()" @keyup.right="navRight()">
      <div class="font-medium mb-4">{{ title }}</div>
      <UseFullscreen v-slot="{ toggle }" class="bg-brand-800 flex flex-col justify-center rounded-lg">
        <button class="outline-none flex justify-center" @keyup.left="navLeft()" @keyup.right="navRight()">
          <img
            :src="thumbnail_preview.file_url"
            alt="post image"
            class="relative block object-contain h-[calc(100vh-200px)]"
            @click="toggle()"
          />
        </button>

      </UseFullscreen >
    </div>

    <div class="flex justify-between">
      <div class="flex mt-4 gap-2 justify-end">
        <AppButton :icon="ArrowDownIcon" name="Left" @click="download(thumbnail_preview.file_url)">Download</AppButton>
      </div>

      <div class="flex mt-4 gap-2 justify-end">
        <AppButton :disabled="preview_index <= 0" :icon="ArrowLeftIcon" name="Left" @click="navLeft()">Left</AppButton>
        <AppButton :disabled="preview_index >= contents.length - 1" :icon="ArrowRightIcon" name="Left" @click="navRight()">Right</AppButton>
      </div>
    </div>
  </MultimediaViewModal>
</template>

<script setup lang="ts">
import { PostContent, User } from '@/globalTypes'
import { ref, reactive } from 'vue'

import DataTransition from '../transitions/DataTransition.vue'
import MultimediaViewModal from '../modals/MultimediaViewModal.vue'
import { ArrowLeftIcon, ArrowRightIcon, ArrowDownIcon } from '@heroicons/vue/24/solid'
import AppButton from '../form/AppButton.vue'
import { UseFullscreen } from '@vueuse/components'
import BasicTransition from '../transitions/BasicTransition.vue'

const $props = defineProps<{
  counts: number
  contents: PostContent[]
  title: string
  createdAt: Date
  user: User
}>()

const open_preview_modal = ref(false)

const thumbnail_preview = reactive<PostContent>({
  id: '',
  name: '',
  data_type: '',
  file_url: '',
  thumbnail_url: ''
})
const preview_index = ref(0)

function openPreview(preview: PostContent, index: number) {
  preview_index.value = index
  Object.assign(thumbnail_preview, preview)
  open_preview_modal.value = true
}

function navLeft() {
  if(preview_index.value > 0) {
    preview_index.value--
  }
  Object.assign(thumbnail_preview, $props.contents[preview_index.value])
}

function navRight() {
  if(preview_index.value < $props.contents.length - 1) {
    preview_index.value++
  }
  Object.assign(thumbnail_preview, $props.contents[preview_index.value])
}

function download(link: string) {
  window.open(link, '_blank')?.focus();
}
</script>
