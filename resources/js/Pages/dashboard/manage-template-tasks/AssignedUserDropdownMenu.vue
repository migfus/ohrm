<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start w-full ">
      <div class="">
        <MenuButton
          as="button"
          :class="[`flex justify-between mb-2 w-full rounded-2xl px-3 py-2 text-sm font-medium  text-brand-700 shadow focus:ring-2 focus:ring-brand-500 bg-white`]"
        >
          <div class="flex text-brand-700 font-semibold">
            <img :src="user.avatar" class="h-4 w-4 rounded-full mr-2 mt-[2px]"/>
            <span>{{ user.name }}</span>
          </div>
          <ChevronDownIcon class="h-5 w-5 text-gray-400"/>
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
          class="z-10 rounded-2xl absolute right-0 w-36 origin-top-right divide-y divide-gray-100 bg-white shadow-xl"
        >
          <div class="px-1 py-1">
            <DropdownContent :icon="XMarkIcon" @selected="$emit('selected', {type: 'remove', TaskUserAccessId: taskUserAccessId})" danger>Remove</DropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { TUser } from '@/globalTypes'
import DropdownContent from '@/components/dropdown/DropdownContent.vue'

defineProps<{
  taskUserAccessId: string
  user: TUser
}>()

const $emit = defineEmits(['selected'])
</script>
