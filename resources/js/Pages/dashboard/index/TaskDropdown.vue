<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start w-full ">
      <div>
        <MenuButton
          as="button"
          :class="[`w-full rounded-2xl text-sm font-medium  text-brand-700 focus:ring-2 focus:ring-brand-500 bg-brand-50`]"
        >
          <div class="flex justify-between flex-grow cursor-pointer shadow rounded-2xl p-1">
            <label class="text-brand-600 ml-2 cursor-pointer">Queuing</label>
            <EllipsisHorizontalCircleIcon
              class="h-5 w-5 ml-1"
              aria-hidden="true"
            />
          </div>
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
            <DropdownContent :icon="CheckCircleIcon">Mark Done</DropdownContent>
            <DropdownContent :icon="XCircleIcon" danger>Reject</DropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { EllipsisHorizontalCircleIcon } from '@heroicons/vue/24/outline'
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/20/solid'
import DropdownContent from '@/components/dropdowns/DropdownContent.vue'

defineProps<{
  index: number
  task_id: number
}>()

</script>
