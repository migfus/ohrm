<template>
  <div>
    <div @click="openCover = true" class="hover:shadow-md rounded-b-3xl transition-all z-0 group bg-white">
      <img  class="h-32 w-full object-cover lg:h-48 rounded-b-3xl shadow group-hover:opacity-80 transition-all" :src="user.cover" alt="" />
      <div class="flex justify-center align-middle group-hover:opacity-100 opacity-0 transition-all">
        <ArrowPathIcon class="h-10 w-10 top-52 group-hover:top-36 absolute mx-auto text-white transition-all"/>
      </div>
    </div>
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
      <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
        <div @click="openAvatar = true" class="flex hover:shadow-xl shadow-lg transition-all cursor-pointer h-24 w-24 rounded-full bg-white ring-4 ring-white sm:h-32 sm:w-32 group">
          <img class="rounded-full group-hover:opacity-80 transition-all group-hover:blur-xs" :src="user.avatar" alt="" />
          <div class="flex justify-center align-middle">
            <ArrowPathIcon class="h-10 w-10 z-10 mx-auto mr-32 mt-32 group-hover:mt-11 absolute text-white group-hover:opacity-100 opacity-0 transition-all"/>
          </div>
        </div>
        <div class="mt-6 sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
          <div class="mt-6 min-w-0 flex-1 sm:hidden md:block">
            <h1 class="truncate text-2xl font-bold text-brand-900">{{ user.name }}</h1>
            <h1 class="truncate font-bold text-brand-500">{{ user.email }}</h1>
          </div>
          <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-x-4 sm:space-y-0">
            <Link href="/dashboard/manage-users"><AppButton :icon="XMarkIcon">Cancel</AppButton></Link>
            <!-- <AppButton :icon="PaperAirplaneIcon">Message</AppButton> -->
            <AppButton v-if="authId != user.id" @click="openRemove = true" color="danger" :icon="XMarkIcon">Remove</AppButton>
          </div>
        </div>
      </div>
      <div class="mt-6 hidden min-w-0 flex-1 sm:block md:hidden">
        <h1 class="truncate text-2xl font-bold text-gray-900">{{ user.name }}</h1>
      </div>
    </div>

    <RemovalPrompt v-model="openRemove" @confirm="removeUser()"/>
    <UploadAvatarModal v-model="avatar" v-model:show="openAvatar" @upload="upload('avatar')" name="Upload Avatar" :ratio="1" :size="[400, 400]"/>
    <UploadAvatarModal v-model="cover" v-model:show="openCover" @upload="upload('cover')" name="Upload Cover" :ratio="639/95" :size="[1278*4, 190*4]"/>
  </div>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import { ref } from 'vue'

import { XMarkIcon, PaperAirplaneIcon, UsersIcon, ArrowPathIcon } from '@heroicons/vue/20/solid'
import AppButton from '@/components/form/AppButton.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import UploadAvatarModal from '../modals/UploadAvatarModal.vue'
import { router } from '@inertiajs/vue3'

const $props = defineProps<{
  user: TUser
  authId: string
}>()

const openRemove = ref(false)
const openAvatar = ref(false)
const openCover = ref(false)
const avatar = ref($props.user.avatar)
const cover = ref($props.user.cover)

function upload(type: string) {
  router.put(`/dashboard/manage-users/${$props.user.id}`, {type: type, avatar: avatar.value, cover: cover.value})
}

function removeUser() {
  router.delete(`/dashboard/manage-users/${$props.user.id}`)
}
</script>
