<template>
  <Combobox as="div" @update:modelValue="value => insertUser(value)" class="gap-2">
    <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">Invite a member</ComboboxLabel>
    <!-- {{  $selectedUserModel }} -->

    <div v-if="filteredUserToShow != undefined" class="relative mt-2 flex-grow">
      <ComboboxButton class="absolute top-2 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
      </ComboboxButton>
      <ComboboxInput class="shadow-inner w-full rounded-xl border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6" @change="searchInput = $event.target.value" />


      <div v-if="loading" class="bg-white shadow-md rounded-2xl mt-1 z-10 absolute w-full">
        <div class="flex justify-center font-medium py-4">
          <ArrowPathIcon class="h-4 w-4 animate-spin"/>
        </div>
      </div>

      <ComboboxOptions v-else-if="filteredUserToShow.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
        <ComboboxOption v-for="user in filteredUserToShow" :key="user.id" :value="user" as="template" v-slot="{ active, selected }">
          <li :class="['relative cursor-pointer select-none py-2 pl-4 pr-4', active ? 'bg-brand-600 text-white' : 'text-gray-900']">
            <span :class="['block truncate', selected && 'font-semibold']">
              <img :src="user.avatar" class="w-5 h-5 inline rounded-full mr-2"/>
              {{ user.name }}
            </span>
          </li>
        </ComboboxOption>
      </ComboboxOptions>

      <div v-else class="bg-white shadow-md rounded-2xl mt-1 z-10 absolute w-full">
        <div class="flex justify-center font-medium py-4">
          No Users Found 😅
        </div>
      </div>
    </div>

  </Combobox>
</template>

<script setup lang="ts">
import { ref, onMounted, watch, computed } from 'vue'
import { TUserWithType, TUser } from '@/globalTypes'
import axios from 'axios'
import { useDebounceFn } from '@vueuse/core'

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
  type: 'head' | 'member'
}>()
const $selectedUserModel = defineModel<TUserWithType[]>()

const searchInput = ref('')
const usersFromDB = ref<{data: TUserWithType[]}>()
const filteredUserToShow = computed(() => {
  return usersFromDB.value?.data.filter(user => !$selectedUserModel.value?.some(r => r.id === user.id))
})
const loading = ref<boolean>(false)

function insertUser(value: TUser) {
  $selectedUserModel.value?.push({type: $props.type, disabled: false, ...value})
}

async function userSearch() {
  loading.value = true
  usersFromDB.value = await axios.get(`/dashboard/manage-users/all`, {
    params: {
      search: searchInput.value,
      filter: $selectedUserModel.value,
    }
  })
  loading.value = false
}

watch(searchInput,
  useDebounceFn(async () => {
    await userSearch()
  }, 500)
)

onMounted(async () => {
  userSearch()
})
</script>
