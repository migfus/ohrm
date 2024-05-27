<template>
  <Combobox as="div" v-model="selectedUser" @update:modelValue="value => $emit('selected', value)" class="gap-2">
    <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">Invite a member</ComboboxLabel>
    <div class="relative mt-2 flex-grow">
      <ComboboxInput class="w-full rounded-xl border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6" @change="query = $event.target.value" />
      <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
      </ComboboxButton>

      <ComboboxOptions v-if="filteredUser.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
        <ComboboxOption v-for="user in filteredUser" :key="user.id" :value="user" as="template" v-slot="{ active, selected }">
          <li :class="['relative cursor-default select-none py-2 pl-8 pr-4', active ? 'bg-brand-600 text-white' : 'text-gray-900']">
            <span :class="['block truncate', selected && 'font-semibold']">
              <img :src="user.avatar" class="w-5 h-5 inline rounded-full mr-2"/>
              {{ user.name }}
            </span>

            <span v-if="selected" :class="['absolute inset-y-0 left-0 flex items-center pl-1.5', active ? 'text-white' : 'text-brand-600']">
              <CheckIcon class="h-5 w-5" aria-hidden="true" />
            </span>
          </li>
        </ComboboxOption>
      </ComboboxOptions>
    </div>

  </Combobox>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { TUser } from '@/globalTypes'

import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxLabel,
  ComboboxOption,
  ComboboxOptions,
} from '@headlessui/vue'

const $props = defineProps<{
 users: TUser []
}>()
const $emit = defineEmits(['selected'])

const query = ref('')
const selectedUser = ref<TUser | null>(null)
const filteredUser = computed(() =>
  query.value === ''
    ? $props.users
    : $props.users.filter((user) => {
        return user.name.toLowerCase().includes(query.value.toLowerCase())
      })
)
</script>
