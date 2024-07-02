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
              <span :class="[priorityName == 'Urgent' && 'animate-bounce delay-100']">default: {{ priorityName }}</span>
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

          <div v-if="userAssigns.length > 0" class="flex -space-x-1 overflow-hidden justify-end">
            <img v-for="row in userAssigns" class="inline-block h-6 w-6 rounded-full ring-2 ring-white" :src="row.user.avatar" alt="" />
            <div v-if="0 < userCount" class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-brand-100 pt-[3px] text-xs text-brand-600" > +{{ userCount }} </div>
          </div>
          <div v-else class="flex justify-between text-brand-500 mt-[3px]">
            <GlobeAsiaAustraliaIcon v-if="task.is_show" class="h-4 w-4 mt-[4px]"/>
            <LockClosedIcon v-else class="h-4 w-4 mt-[4px]"/>
            <div>No user assigned.</div>
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
            <DropdownContent :icon="PencilIcon" :href="`/dashboard/manage-template-tasks/${id}/edit`">Edit</DropdownContent>
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
import { ChevronDownIcon, PencilIcon, LockClosedIcon, GlobeAsiaAustraliaIcon } from '@heroicons/vue/20/solid'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import DropdownContent from '@/components/dropdown/DropdownContent.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import { THeroIcon, TTask, TTaskTemplate, TUser } from '@/globalTypes'

defineProps<{
  id: string
  index: number
  name: string
  description: string
  color: string
  icon: THeroIcon
  priorityName: string
  userAssigns: {
    user: TUser
  } []
  userCount: number
  task: TTaskTemplate
}>()

const $emit = defineEmits(['selected', 'updated'])
const selectedEdit = ref<boolean>(false)
const inputValue = ref<string>('')

function updateEdit() {
  selectedEdit.value = false
  $emit('updated', inputValue.value)
}
</script>
