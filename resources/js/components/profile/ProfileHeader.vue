<template>
  <div>
    <div>
      <img class="h-32 w-full object-cover lg:h-48 rounded-b-3xl" :src="user.cover" alt="" />
    </div>
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
      <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
        <div class="flex">
          <img @click="openAvatar = true" class="hover:shadow-xl cursor-pointer h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32" :src="user.avatar" alt="" />
        </div>
        <div class="mt-6 sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
          <div class="mt-6 min-w-0 flex-1 sm:hidden md:block">
            <h1 class="truncate text-2xl font-bold text-brand-900">{{ user.name }}</h1>
            <h1 class="truncate font-bold text-brand-500">{{ user.email }}</h1>
          </div>
          <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-x-4 sm:space-y-0">
            <AppButton :icon="PaperAirplaneIcon">Message</AppButton>
            <AppButton @click="open = true" color="danger" :icon="XMarkIcon">Remove</AppButton>
          </div>
        </div>
      </div>
      <div class="mt-6 hidden min-w-0 flex-1 sm:block md:hidden">
        <h1 class="truncate text-2xl font-bold text-gray-900">{{ user.name }}</h1>
      </div>
    </div>

    <RemovalPrompt v-model="open"/>
    <UploadAvatarModal v-model="avatar" v-model:show="openAvatar" :size="[100, 100]"/>
  </div>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import { ref } from 'vue'

import { XMarkIcon, PaperAirplaneIcon } from '@heroicons/vue/20/solid'
import AppButton from '@/components/form/AppButton.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import UploadAvatarModal from '../modals/UploadAvatarModal.vue'

const $props = defineProps<{
  user: TUser
}>()

const open = ref(false)
const openAvatar = ref(false)
const avatar = ref($props.user.avatar)
</script>
