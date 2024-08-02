<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start mb-2 w-full ">
      <div>
        <MenuButton
          as="button"
          :class="[`w-full rounded-2xl px-3 py-2 text-sm font-medium bg-white shadow focus:ring-2 focus:ring-brand-500 truncate`]"
        >
          <slot></slot>
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
        <MenuItems class="z-10 rounded-2xl absolute right-0 mt-1 w-36 origin-top-right divide-y divide-gray-100 bg-white shadow-xl" >
          <div class="px-1 py-1">
            <DropdownContent
              :icon=" ArrowRightCircleIcon "
              :href="route('dashboard.manage-groups.edit', { manage_group: groupId})"
            >
              More Info
            </DropdownContent>

            <DropdownContent
              :icon="XMarkIcon"
              @selected="$emit('selected', {type: 'remove', id: id})"
              danger
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
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { ArrowRightCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import DropdownContent from '@/components/dropdowns/DropdownContent.vue'

defineProps<{
  id: string
  groupId: string
}>()

const $emit = defineEmits(['selected'])

onErrorCaptured((e) => errorAlert('/dashboard/manage-users/GroupDowpdownMenu', e))
</script>
