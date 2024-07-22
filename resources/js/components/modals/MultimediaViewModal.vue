<template>
  <TransitionRoot as="template" :show="$open_modal_model">
    <Dialog as="div" class="relative z-40" @close="$open_modal_model = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" ></div>
      </TransitionChild>

      <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel :class="['flex-grow relative text-left rounded-2xl bg-brand-50 shadow-xl transition-all max-w-3xl']">
              <!-- NOTE: HEADER -->
              <div class="m-4 flex justify-between">
                <div class="flex">
                  <img :src="user.avatar" class="h-10 w-10 rounded-full inline mr-2"/>
                  <div class="flex flex-col">
                    <label class="font-medium">{{ user.name }}</label>
                    <label class="text-sm">{{ dateTimeFormatted(createdAt) }}</label>
                  </div>
                </div>
                <AppButton :icon="XMarkIcon" name="close" @click="$open_modal_model = false" color="transparent">Close</AppButton>
              </div>

              <!-- NOTE: CONTENT -->
              <div class="grid grid-cols-1 mx-4 gap-4">
                <div class="col-span-3 lg:col-span-2">
                  <slot></slot>
                </div>
                <div class="col-span-3 lg:col-span-1 flex flex-col gap-2 bg-white rounded-2xl shadow p-4">
                  <div v-for="row in 2" class="">
                    <div class="w-full text-white bg-brand-50 p-2 rounded-2xl shadow flex">
                      <img :src="user.avatar" class="h-6 w-6 rounded-full inline mr-2"/>
                      <div class="flex flex-col">
                        <span class="text-brand-800 text-xs font-medium">[User name] - 2:44 AM</span>
                        <span class="text-brand-800 text-sm">
                          Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
import { dateTimeFormatted } from '@/converter'
import { User } from '@/globalTypes'

import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/solid'
import AppButton from '../form/AppButton.vue'

defineProps<{
  user: User
  createdAt: string
}>()
const $open_modal_model = defineModel<boolean>()
</script>
