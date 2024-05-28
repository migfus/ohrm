<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start mb-2 w-full ">
      <form v-if="selectedEdit" @submit.prevent="updateEdit()">
        <AppInput v-model="inputValue" :error="undefined" name="Task" size="sm" noLabel/>
        <div class="flex justify-end mt-2">
          <AppButton size="sm" color="brand" :icon="PencilIcon" type="submit">Update</AppButton>
        </div>
      </form>
      <div v-else>
        <MenuButton
          as="button"
          :class="[`flex w-full justify-between rounded-2xl px-3 py-2 text-sm font-medium bg-white shadow focus:ring-2 focus:ring-brand-500`]"
        >
          <div class="flex justify-start">
            <span class="">{{ name }}</span>
          </div>
          <ChevronDownIcon
            class="-mr-1 ml-2 h-5 w-5"
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

const $props = defineProps<{
  index: number
  name: string
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
