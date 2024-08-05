<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start mb-2 w-full ">
      <div>
        <MenuButton
          as="button"
          class="inline-flex w-full justify-between rounded-2xl px-3 py-2 text-sm font-medium bg-white shadow focus:ring-2 focus:ring-brand-500"
        >
          <slot></slot>
          <EllipsisVerticalIcon
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
          class="z-10 rounded-2xl absolute right-0 mt-2 w-36 origin-top-right divide-y divide-gray-100 bg-white shadow-lg"
        >
          <div class="px-1 py-1">
            <DropdownContent :icon="CheckCircleIcon" @selected="$emit('selected', {type: 'visibility', id: id})">Show</DropdownContent>
            <DropdownContent :icon="PencilIcon" @selected="$emit('selected', {type: 'edit', id: id})">Edit</DropdownContent>
            <DropdownContent :icon="XMarkIcon" @selected="$emit('selected', {type: 'remove', id: id})" danger>Remove</DropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
import { PencilIcon, XMarkIcon, CheckCircleIcon } from '@heroicons/vue/24/outline'
import DropdownContent from '@/components/dropdowns/DropdownContent.vue'

defineProps<{
  id: string
}>()

const $emit = defineEmits(['selected'])

onErrorCaptured((e) => errorAlert('/dashboard/manage-groups/edit/MemberDropdown', e))
</script>
