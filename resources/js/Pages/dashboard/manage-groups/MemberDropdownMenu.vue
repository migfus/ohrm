<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start mb-2 w-full ">
      <div>
        <MenuButton
          as="button"
          :class="[disabled && 'text-brand-700 bg-brand-200', `inline-flex w-full justify-between rounded-2xl px-3 py-2 text-sm font-medium bg-white shadow focus:ring-2 focus:ring-brand-500`]"
        >
          <slot></slot>
          <EllipsisVerticalIcon
            v-if="!disabled"
            class="-mr-1 ml-2 h-5 w-5  hover:text-violet-100"
            aria-hidden="true"
          />
          <StarIcon
            v-else
            class="mt-[2px] h-4 w-4  hover:text-violet-100"
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
          class="z-10 rounded-2xl absolute right-0 mt-1 w-36 origin-top-right divide-y divide-gray-100 bg-white shadow-xl"
        >
          <div class="px-1 py-1">
            <DropdownContent :icon="ArrowRightCircleIcon" :href="`/dashboard/manage-users/${userId}/edit`">More Info</DropdownContent>
            <DropdownContent
              v-if="!disabled"
              :icon="XMarkIcon"
              danger
              @selected="$emit('selected', {type: 'remove', id: id})"
            >
              Remove
            </DropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { errorAlert } from '@/converter'
import { onErrorCaptured } from 'vue'

import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { EllipsisVerticalIcon, StarIcon, ArrowRightCircleIcon } from '@heroicons/vue/20/solid'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import DropdownContent from '@/components/dropdowns/DropdownContent.vue'

defineProps<{
  id: string
  userId: string
  disabled: boolean | undefined
}>()

const $emit = defineEmits(['selected'])

onErrorCaptured((e) => errorAlert('/dashboard/manage-groups/MemberDropdownMenu', e))
</script>
