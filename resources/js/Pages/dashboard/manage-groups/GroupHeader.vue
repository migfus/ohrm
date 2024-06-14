<template>
  <div>
    <div class="hover:shadow-md rounded-b-3xl transition-all hover:opacity-80 z-0 -mt-6">
      <img @click="openCover = true" class="h-32 w-full object-cover lg:h-48 rounded-b-3xl" :src="$cover" alt="" />
    </div>
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
      <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
        <div class="flex">
          <img @click="openAvatar = true" class="shadow transition-all cursor-pointer h-24 w-24 rounded-2xl ring-4 ring-white sm:h-32 sm:w-32 hover:opacity-80" :src="$avatar" alt="" />
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
          <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-x-4 sm:space-y-0">
            <AppButton href="/dashboard/manage-groups" :icon="XMarkIcon" :color="confirmButton.color == 'danger' ? '' : ''">Cancel</AppButton>

            <AppButton :icon="confirmButton.icon" @click="$emit('confirm')" :color="confirmButton.color">{{ confirmButton.text }}</AppButton>
          </div>
        </div>
      </div>
      <div class="mt-6 hidden min-w-0 flex-1 sm:block md:hidden">
        <h1 class="truncate text-2xl font-bold text-gray-900">{{ $name }}</h1>
      </div>
    </div>

    <UploadAvatarModal
      v-model="$avatar"
      v-model:show="openAvatar"
      name="Upload Avatar"
      :ratio="1"
      :size="[400, 400]"
      @upload="image => $emit('uploadAvatar', image)"
    />
    <UploadAvatarModal
      v-model="$cover"
      v-model:show="openCover"
      name="Upload Cover"
      :ratio="639/95"
      :size="[1278*4, 190*4]"
      @upload="image => $emit('uploadCover', image)"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, FunctionalComponent, computed } from 'vue'
import { TGroupMember } from '@/globalTypes'

import { XMarkIcon } from '@heroicons/vue/20/solid'
import AppButton from '@/components/form/AppButton.vue'
import UploadAvatarModal from '@/components/modals/UploadAvatarModal.vue'

defineProps<{
  admins: TGroupMember []
  confirmButton: {
    text: string
    icon: FunctionalComponent
    color: string
  }
}>()
const $emit = defineEmits(['confirm', 'uploadAvatar', 'uploadCover'])

const $avatar = defineModel<string>('avatar')
const $cover = defineModel<string>('cover')
const $name = defineModel<string>('name')

const openAvatar = ref(false)
const openCover = ref(false)
</script>
