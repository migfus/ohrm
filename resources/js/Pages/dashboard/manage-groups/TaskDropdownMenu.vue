<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start w-full ">
      <form v-if="selectedEdit" @submit.prevent="updateEdit()">
        <AppInput v-model="inputValue" :error="undefined" name="Task" size="sm" noLabel/>
        <div class="flex justify-end mt-2">
          <AppButton size="sm" color="brand" :icon="PencilIcon" type="submit">Update</AppButton>
        </div>
      </form>
      <div v-else class="">
        <MenuButton
          as="button"
          :class="[`w-full rounded-2xl px-3 py-2 text-sm font-medium  text-brand-700 shadow focus:ring-2 focus:ring-brand-500 bg-white`]"
        >
          <div class="flex justify-between mb-2 flex-grow">
            <div v-html="icon.content" :class="[priorityName == 'Urgent' && 'animate-bounce', 'h-4 w-4 mr-2 mt-[2px] align-middle']" :style="`color: #${color}`"></div>
            <div class="flex justify-center flex-grow">
              <span :class="[priorityName == 'Urgent' && 'animate-bounce delay-100']">{{ priorityName }}</span>
            </div>
            <ChevronDownIcon
              class="-mr-1 ml-2 h-5 w-5"
              aria-hidden="true"
            />
          </div>
          <div class="flex text-brand-700 font-semibold">
            <span>{{ name }}</span>
          </div>
          <div class="flex text-brand-400 font-normal line-clamp-2 justify-start">
            <span>{{ description }}</span>
          </div>

          <div class="flex -space-x-1 overflow-hidden justify-end ">
            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white " src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="" />
            <div class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-brand-100 pt-[3px] text-xs text-brand-600" > +9 </div>
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
            <!-- <DropdownContent :icon="CheckCircleIcon" @selected="$emit('selected', {type: 'visibility', index: index})">Show</DropdownContent> -->
            <DropdownContent :icon="PencilIcon" @selected="toggleEdit()">Edit</DropdownContent>
            <DropdownContent :icon="XMarkIcon" @selected="$emit('selected', {type: 'remove', index: index})" danger>Remove</DropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { ChevronDownIcon, PencilIcon } from '@heroicons/vue/20/solid'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import DropdownContent from '@/components/dropdown/DropdownContent.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import { THeroIcon } from '@/globalTypes'

const $props = defineProps<{
  index: number
  name: string
  description: string
  color: string
  icon: THeroIcon
  priorityName: string
}>()

const $emit = defineEmits(['selected', 'updated'])
const selectedEdit = ref<boolean>(false)
const inputValue = ref<string>('')

function toggleEdit() {
  selectedEdit.value = true
  inputValue.value = $props.name
}

function updateEdit() {
  selectedEdit.value = false
  $emit('updated', inputValue.value)
}
</script>
