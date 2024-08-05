<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start w-full ">
      <div>
        <MenuButton
          as="button"
          :class="[`w-full rounded-2xl text-sm font-medium  text-brand-700 focus:ring-2 focus:ring-brand-500 bg-gray-100`]"
        >
          <div class="flex justify-between flex-grow cursor-pointer shadow rounded-2xl p-1">
            <div v-html="current_task_status.hero_icon.content" class="h-4 w-4 mx-1 mt-[3px]" :style="`color: #${current_task_status.text_color}`"></div>
            <label class="cursor-pointer ml-1">
              {{ current_task_status.past_name }}
            </label>
            <EllipsisVerticalIcon class="h-4 w-4 mx-1 mt-0.5"/>

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
          <div class="px-1 py-1 gap-1 flex flex-col">
            <TaskDropdownContent
              v-for="status in task_status.filter(row => row.id != current_task_status.id)"
              :key="status.present_name"
              :icon_html="status.hero_icon.content"
              :bg_color="status.bg_color"
              :text_color="status.text_color"
              @selected="$emit('selectedStatus', status.id, task_id)"
            >
              {{ status.present_name }}
            </TaskDropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'
import { TaskStatus } from '@/globalTypes'

import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import TaskDropdownContent from './TaskDropdownContent.vue'
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'

defineProps<{
  index: number
  task_id: number
  task_status: TaskStatus[]
  current_task_status: TaskStatus
}>()

const $emit = defineEmits(['selectedStatus'])

onErrorCaptured((e) => errorAlert('/dashboard/index/PendingTasks', e))
</script>
