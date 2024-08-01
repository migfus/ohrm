<template>
  <div class="-mt-6 z-0">
    <div @click="open_cover = true" class="hover:shadow-md rounded-b-3xl transition-all z-0 group bg-white">
      <img  class="h-32 w-full object-cover lg:h-48 rounded-b-3xl shadow group-hover:opacity-80 transition-all" :src="$cover" alt="" />
      <div class="flex justify-center align-middle group-hover:opacity-100 opacity-0 transition-all">
        <ArrowPathIcon class="h-10 w-10 top-52 group-hover:top-36 absolute mx-auto text-white transition-all"/>
      </div>
    </div>
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
      <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
        <div @click="open_avatar = true" class="flex hover:shadow-xl shadow-lg transition-all cursor-pointer h-24 w-24 rounded-full bg-white ring-4 ring-white sm:h-32 sm:w-32 group">
          <img class="rounded-full group-hover:opacity-80 transition-all group-hover:blur-xs" :src="$avatar" alt="" />
          <div class="flex justify-center align-middle">
            <ArrowPathIcon class="h-10 w-10 z-10 mx-auto mr-32 mt-32 group-hover:mt-11 absolute text-white group-hover:opacity-100 opacity-0 transition-all"/>
          </div>
        </div>
        <div class="mt-6 sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
          <div class="mt-6 min-w-0 flex-1 sm:hidden md:block">
            <h1 class="truncate text-2xl font-bold text-brand-900">{{ name }}</h1>
            <div class="flex gap-4">
              <h1 v-for="head in admins" :key="head.id" class="truncate font-semibold text-brand-500 inline">
                <img :src="head.user?.avatar" class="h-5 w-5 inline rounded-xl mr-1"/>
                {{ head.user?.name }}
              </h1>
            </div>

          </div>

        </div>
      </div>
      <div class="mt-6 hidden min-w-0 flex-1 sm:block md:hidden">
        <h1 class="truncate text-2xl font-bold text-gray-900">{{ $name }}</h1>
      </div>
    </div>

    <UploadAvatarModal
      v-model="$avatar"
      v-model:show="open_avatar"
      name="Upload Avatar"
      :ratio="1"
      :size="[400, 400]"
      @upload="image => $emit('uploadAvatar', image)"
    />
    <UploadAvatarModal
      v-model="$cover"
      v-model:show="open_cover"
      name="Upload Cover"
      :ratio="639/95"
      :size="[1278*4, 190*4]"
      @upload="image => $emit('uploadCover', image)"
    />

    <RemovalPrompt v-model="open_prompt" title="Deletion Group" confirmMessage="Yes, Delete Group!" @confirm="$emit('removeGroup')">
      Do you want to remove this group? This action cannot be undone.
    </RemovalPrompt>
  </div>
</template>

<script setup lang="ts">
import { ref, FunctionalComponent } from 'vue'
import { GroupMember } from '@/globalTypes'

import { XMarkIcon, ArrowPathIcon } from '@heroicons/vue/20/solid'
import AppButton from '@/components/form/AppButton.vue'
import UploadAvatarModal from '@/components/modals/UploadAvatarModal.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'

defineProps<{
  admins: GroupMember []
  confirmButton: {
    text: string
    icon: FunctionalComponent
    color: string
  }
}>()
const $emit = defineEmits(['removeGroup', 'uploadAvatar', 'uploadCover'])

const $avatar = defineModel<string>('avatar')
const $cover = defineModel<string>('cover')
const $name = defineModel<string>('name')

const open_avatar = ref(false)
const open_cover = ref(false)
const open_prompt = ref(false)

function removeGroupPrompt() {
  open_prompt.value = true
}
</script>
