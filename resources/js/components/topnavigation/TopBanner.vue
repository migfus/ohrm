
<script setup>
import { useStorage } from '@vueuse/core'
import { MegaphoneIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import BasicTransition from '@/components/transitions/BasicTransition.vue'

const noBanner = useStorage('noBanner', false);

function removeBanner() {
  noBanner.value = true
}
</script>


<template>
  <Transition
    enter-active-class="transition ease-out duration-200"
    enter-from-class="transform opacity-0"
    enter-to-class="transform opacity-100"

    leave-active-class="transition ease-in duration-200"
    leave-from-class="transform opacity-100"
    leave-to-class="transform opacity-0"
    mode="out-in"
    appear
  >
    <div v-if="!noBanner" class="bg-brand-600">
      <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between">
          <div class="flex w-0 flex-1 items-center">
            <span class="flex rounded-lg bg-brand-800 p-2">
              <MegaphoneIcon class="h-6 w-6 text-white" aria-hidden="true" />
            </span>
            <p class="ml-3 truncate font-medium text-white">
              <!-- <span class="md:hidden">We announced a new product!</span> -->
              <span class="">In UI designing phase, not a working website.</span>
            </p>
          </div>
          <div class="order-3 mt-2 w-full flex-shrink-0 sm:order-2 sm:mt-0 sm:w-auto">
            <a href="https://migfus.net" class="flex items-center justify-center rounded-md border border-transparent bg-white px-4 py-2 text-sm font-medium text-brand-600 shadow-sm hover:bg-brand-50">migfus.net</a>
          </div>
          <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
            <button @click="removeBanner" type="button" class="-mr-1 flex rounded-md p-2 hover:bg-brand-500 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
              <span class="sr-only">Dismiss</span>
              <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>

</template>
