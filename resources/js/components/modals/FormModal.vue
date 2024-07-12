<template>
  <TransitionRoot as="template" :show="$open_modal_model">
    <Dialog as="div" class="relative z-10" @close="$open_modal_model = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" ></div>
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel :class="[`sm:${size}`, 'flex-grow relative text-left rounded-2xl bg-white shadow-xl transition-all sm:w-full max-w-full']">
              <!-- NOTE: FORM MODAL -->
              <BasicCard :icon :title :description size="lg">
                <!-- NOTE: CONTENTS -->
                <slot></slot>
              </BasicCard>
            </DialogPanel>

          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
import { FunctionalComponent } from 'vue'

import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import BasicCard from '../cards/BasicCard.vue'

defineProps<{
  icon: FunctionalComponent
  title: string
  description: string
  size: string
}>()
const $open_modal_model = defineModel<boolean>()
</script>
