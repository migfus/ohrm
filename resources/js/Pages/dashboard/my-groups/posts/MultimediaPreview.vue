<template>
  <!-- SECTION: POST PREVIEW -->
  <!-- NOTE: 3 & below PREVIEW -->
  <DataTransition v-if="counts < 4" class="flex my-4 gap-2">
    <div v-for="block, idx in contents" @click="openPreview(block, idx)">
      <MultiPreview :preview="block" :counts="0"/>
    </div>
  </DataTransition>

  <!-- NOTE: 5+ PREVIEW -->
  <DataTransition v-else class="grid grid-cols-2 my-4 gap-1">
    <div v-for="block, idx in contents.slice(0, 4)" class="relative cursor-pointer" @click="openPreview(block, idx)">
      <div v-if="idx > 2 && counts > 4" class="overflow-hidden w-full rounded-lg flex bg-gray-600/75 shadow h-full" >
        <MultiPreview :preview="block" :counts="counts - 3"/>
      </div>
      <div v-else >
        <MultiPreview :preview="block" :counts="0"/>
      </div>
    </div>
  </DataTransition>


  <!-- SECTION: MODAL VIEW -->
  <MultimediaViewModal v-model="open_preview_modal" :user :createdAt >
    <div class="bg-white p-4 rounded-2xl shadow" @keyup.left="navLeft()" @keyup.right="navRight()">
      <div class="font-medium mb-4">{{ title }}</div>
      <UseFullscreen v-slot="{ toggle }" class="bg-brand-800 flex flex-col justify-center rounded-lg">
        <button class="outline-none flex justify-center" @keyup.left="navLeft()" @keyup.right="navRight()">
          <!-- NOTE: VIDEO -->
          <div v-if="isVideo(thumbnail_preview.file_url)" class="flex justify-center">
            <video controls class="object-cover shadow">
              <source :src="thumbnail_preview.file_url" type="video/mp4">
            </video>
          </div>
          <!-- NOTE: IMAGE -->
          <img
            v-else
            :src="thumbnail_preview.file_url"
            alt="post image"
            class="relative block object-contain h-[calc(100vh-200px)]"
            @click="toggle()"
            style="image-rendering: pixelated;"
          />
        </button>

      </UseFullscreen >
    </div>

    <div class="flex justify-between">
      <div class="flex my-4 gap-2 justify-end">
        <AppButton :icon="ArrowDownIcon" name="Left" :href="thumbnail_preview.file_url" externalLink>Download</AppButton>
      </div>

      <div class="flex my-4 gap-2 justify-end">
        <AppButton :disabled="preview_index <= 0" :icon="ArrowLeftIcon" name="Left" @click="navLeft()">Left</AppButton>
        <AppButton :disabled="preview_index >= contents.length - 1" :icon="ArrowRightIcon" name="Left" @click="navRight()">Right</AppButton>
      </div>
    </div>
  </MultimediaViewModal>
</template>

<script setup lang="ts">
import { PostContent, User } from '@/globalTypes'
import { ref, reactive, onErrorCaptured } from 'vue'
import { isVideo, errorAlert } from '@/converter'

import DataTransition from '@/components/transitions/DataTransition.vue'
import MultimediaViewModal from '@/components/modals/MultimediaViewModal.vue'
import { ArrowLeftIcon, ArrowRightIcon, ArrowDownIcon } from '@heroicons/vue/24/solid'
import AppButton from '@/components/form/AppButton.vue'
import { UseFullscreen } from '@vueuse/components'
import MultiPreview from '@/components/preview/MultiPreview.vue'

const $props = defineProps<{
  counts: number
  contents: PostContent[]
  title: string
  createdAt: string
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

onErrorCaptured((e) => errorAlert('/dashboard/my-groups/posts/MultimediaPreview', e))
</script>
