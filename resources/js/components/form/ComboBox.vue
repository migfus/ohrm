<template>
  <!-- NOTE: COMBOBOX -->
  <Combobox as="div" v-model="$model">
    <!-- NOTE: LABEL -->
    <ComboboxLabel class="block text-sm font-medium text-gray-700">Select {{  name }}</ComboboxLabel>
    <div class="relative mt-1">
      <!-- NOTE: INPUT -->
      <ComboboxInput @change="query = $event.target.value" :displayValue="(row: any) => row?.display_name" class="w-full rounded-xl border border-gray-300 bg-white py-2 pl-3 pr-10 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 sm:text-sm" />
      <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
      </ComboboxButton>

      <!-- NOTE: OPTIONS -->
      <ComboboxOptions v-if="filtered_rows.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
        <ComboboxOption v-for="row in filtered_rows" :key="row.id" :value="row" as="template" v-slot="{ active, selected }">
          <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-brand-600 text-white' : 'text-gray-900']">
            <span :class="['block truncate', selected && 'font-semibold']">
              {{ row.display_name ?? row.name }}
            </span>

            <span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-brand-600']">
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

import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxLabel,
  ComboboxOption,
  ComboboxOptions,
} from '@headlessui/vue'

interface Data {
  name: string
  display_name: string
  id: string
}

const $props = defineProps<{
  name: string
  data: Data []
}>()
const $model = defineModel<Data>()

const query = ref('')
const filtered_rows = computed(() =>
  query.value === ''
    ? $props.data
    : $props.data.filter((row) => {
        return row.display_name.toLowerCase().includes(query.value.toLowerCase())
      })
)
</script>
