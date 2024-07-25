<template>
  <div class="">
    <Menu as="div" class="relative inline-block text-left justify-start w-full ">

      <form v-if="selected_edit" @submit.prevent="updateEdit()">
        <AppInput v-model="input_value" :error="undefined" name="Task" size="sm" noLabel/>
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
            <div
              v-html="taskTemplate.task_priority.hero_icon.content"
              :class="[taskTemplate.task_priority.name == 'Urgent' && 'animate-bounce', 'h-4 w-4 mr-2 mt-[2px] align-middle']"
              :style="`color: #${taskTemplate.task_priority.color}`">
            </div>
            <div class="flex flex-grow">
              <span :class="[taskTemplate.task_priority.name == 'Urgent' && 'animate-bounce delay-100']">
                {{ taskTemplate.task_priority.name }}
              </span>
            </div>
            <ChevronDownIcon
              class="-mr-1 ml-2 h-5 w-5"
              aria-hidden="true"
            />
          </div>
          <div class="flex text-brand-700 font-semibold">
            <span>{{ taskTemplate.name }}</span>
          </div>
          <div class="flex text-brand-400 font-normal line-clamp-2 justify-start mb-2">
            <span>{{ taskTemplate.message }}</span>
          </div>

          <div class="flex justify-between">
            <!-- NOTE: VISIBILITY -->
            <GlobeAsiaAustraliaIcon v-if="taskTemplate.is_show" class="h-4 w-4 mt-[4px] text-brand-500"/>
            <LockClosedIcon v-else class="h-4 w-4 mt-[4px] text-brand-500"/>

            <!-- NOTE: MEMBERS -->
            <div v-if="taskTemplate.task_user_access.length > 0" class="flex -space-x-1 overflow-hidden justify-end">
              <img v-for="row in taskTemplate.task_user_access" class="inline-block h-6 w-6 rounded-full ring-2 ring-white" :src="row.user.avatar" alt="" />
              <div v-if="0 < taskTemplate.task_user_access_count" class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-brand-100 pt-[3px] text-xs text-brand-600" >
                +{{ taskTemplate.task_user_access_count }}
              </div>
            </div>
            <div v-else class="flex justify-between text-brand-500 mt-[3px]">
              <div>No member assigned.</div>
            </div>
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
            <DropdownContent :icon="PencilIcon" :href="`/dashboard/manage-template-tasks/${taskTemplate.id}/edit`">Edit</DropdownContent>
            <DropdownContent :icon="XMarkIcon" @selected="$emit('selected', {type: 'remove', index: index})" danger>Remove</DropdownContent>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { TaskTemplate } from '@/globalTypes'

import { Menu, MenuButton, MenuItems, } from '@headlessui/vue'
import { ChevronDownIcon, PencilIcon, LockClosedIcon, GlobeAsiaAustraliaIcon } from '@heroicons/vue/20/solid'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import DropdownContent from '@/components/dropdowns/DropdownContent.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'


defineProps<{
  index: number
  taskTemplate: TaskTemplate
}>()

const $emit = defineEmits(['selected', 'updated'])
const selected_edit = ref<boolean>(false)
const input_value = ref<string>('')

function updateEdit() {
  selected_edit.value = false
  $emit('updated', input_value.value)
}
</script>
