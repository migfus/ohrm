<template>
  <Combobox as="div" @update:modelValue="value => AddMember(value)" class="gap-2 mt-4">
    <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">Assign a member</ComboboxLabel>

    <div class="relative mt-2 flex-grow">
      <ComboboxButton class="absolute top-2 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
      </ComboboxButton>
      <ComboboxInput @change="search_input = $event.target.value"  class="shadow-inner w-full rounded-xl border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6" />


      <div v-if="loading" class="bg-white shadow-md rounded-2xl mt-1 z-10 absolute w-full">
        <div class="flex justify-center font-medium py-4">
          <ArrowPathIcon class="h-4 w-4 animate-spin"/>
        </div>
      </div>

      <div v-else-if="users_from_DB !== undefined">
        <ComboboxOptions v-if="users_from_DB.data.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
          <ComboboxOption v-for="user in users_from_DB.data" :key="user.id" :value="user" as="template" v-slot="{ active, selected }">
            <li :class="['relative cursor-pointer select-none py-2 pl-4 pr-4', active ? 'bg-brand-600 text-white' : 'text-gray-900']">
              <span :class="['block truncate', selected && 'font-semibold']">
                <img :src="user.avatar" class="w-5 h-5 inline rounded-full mr-2"/>
                {{ user.name }}
              </span>
            </li>
          </ComboboxOption>
        </ComboboxOptions>

        <!-- NOTE: DEBUGGING PURPOSES
        count [{{  usersFromDB.data.length }}]
        <div v-for="user in usersFromDB.data">{{ user.name }}</div> -->
      </div>
    </div>

  </Combobox>
</template>

<script setup lang="ts">
import { ref, watch, onErrorCaptured } from 'vue'
import { User } from '@/globalTypes'
import axios from 'axios'
import { useDebounceFn } from '@vueuse/core'
import { errorAlert } from '@/converter'

import { ChevronUpDownIcon, ArrowPathIcon } from '@heroicons/vue/20/solid'
import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxLabel,
  ComboboxOption,
  ComboboxOptions,
} from '@headlessui/vue'

const $props = defineProps<{
  groupId: string
  taskTemplateId: string
}>()

const search_input = ref('')
const users_from_DB = ref<{data: User[]}>()
const loading = ref<boolean>(false)
const $emit = defineEmits(['addMember'])

function AddMember(value: User) {
 $emit('addMember', value)
 userSearch()
}

async function userSearch() {
  loading.value = true
  users_from_DB.value = await axios.get(`/dashboard/manage-template-tasks/users-suggestion/${$props.groupId}`, {
    params: { search: search_input.value, task_template_id: $props.taskTemplateId }
  })
  loading.value = false
}

watch(search_input,
  useDebounceFn(async () => {
    await userSearch()
  }, 500)
)

onErrorCaptured((e) => errorAlert('/dashboard/manage-template-tasks/UserComboBox', e))
</script>
