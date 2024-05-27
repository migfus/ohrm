<template>
  <div class="">
    <Menu as="div" class="w-full relative inline-block text-left bg-white justify-start shadow rounded-2xl">
      <div>
        <MenuButton
          class="inline-flex w-full justify-between rounded-2xl px-3 py-2 text-sm font-medium"
        >
          <slot></slot>
          <ChevronDownIcon
            class="-mr-1 ml-2 h-5 w-5  hover:text-violet-100"
            aria-hidden="true"
          />
        </MenuButton>
      </div>

      <transition
        enter-active-class="transition duration-100 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-75 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <MenuItems
          class="rounded-2xl absolute right-0 mt-2 w-36 origin-top-right divide-y divide-gray-100 bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
        >
          <div class="px-1 py-1">
            <DropdownContent :icon="CheckCircleIcon" @selected="Selected('Visibility')">Show</DropdownContent>
            <DropdownContent :icon="PencilIcon" @selected="Selected('Edit')">Edit</DropdownContent>
            <DropdownContent :icon="XMarkIcon" @selected="Selected('Remove')" :danger="true">Remove</DropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { PencilIcon, XMarkIcon, CheckCircleIcon } from '@heroicons/vue/24/outline'
import DropdownContent from '@/components/dropdown/DropdownContent.vue'
import { router } from '@inertiajs/vue3'

const $props = defineProps<{
  key: string
}>()

function Selected(type: string) {
  switch(type) {
    case 'Remove':
      break;
    case 'Visibility':
      break;
    default:
      // popup for edit
  }
  alert('Selected')
  // router.put(`/dashboard/tasks/${$props.id}`)
}
</script>
