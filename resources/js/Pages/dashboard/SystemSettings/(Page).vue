<script setup lang="ts">
import { ref } from 'vue'
import { TProps } from '@/globalTypes'
import { router } from '@inertiajs/vue3'

import AppButton from '@/components/form/AppButton.vue'
import AppInput from '@/components/form/AppInput.vue'
import { PencilIcon } from '@heroicons/vue/24/outline'
import BasicTransition from '@/components/transitions/BasicTransition.vue'

interface TSystemSettings {
  id: number
  system_setting_type: {
    name: string
  }
  name: string
  description: string
  value: string
}

interface TData {
  id: number
  name: string
  description: string
  href: string
  system_settings: TSystemSettings []
}

interface TErrorAndTDataWithTProps extends TProps {
  errors?: {
    id: string
    value: string
  }
  data: TData []
}

const $props = defineProps<TErrorAndTDataWithTProps>()

const selected = ref(0)
const selectedData = ref<number | null>(null)

function submit(row: TSystemSettings) {
  router.post('/dashboard/system-settings', {id: row.id, value: row.value})
  selectedData.value = null
}
</script>


<template>
  <div>
    <div class="flex flex-col max-w-7xl md:px-8 xl:px-0 mx-4">
      <main class="flex-1">
        <div class="relative mx-auto md:px-8 xl:px-0">
          <div class="pt-10 pb-16">
            <div class="px-4 sm:px-6 md:px-0">
              <h1 class="text-3xl font-bold tracking-tight text-brand-900">System Settings</h1>
            </div>
            <div class="px-4 sm:px-6 md:px-0">
              <div class="py-6">
                <!-- Tabs -->
                <div class="lg:hidden">
                  <label for="selected-tab" class="sr-only">Select a tab</label>
                  <select v-model="selected" id="selected-tab" name="selected-tab" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm">
                    <option v-for="(tab, index) in $props.data" :key="tab.name" :value="index">
                      {{ tab.name }}
                    </option>
                  </select>
                </div>
                <div class="hidden lg:block">
                  <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                      <div
                        v-for="(tab, index) in $props.data"
                        :key="tab.name"
                        @click="selected = index"
                        :class="[
                          selected == index ?
                            'border-brand-500 text-brand-600' :
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                          'cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm']"
                        >
                        {{ tab.name }}
                      </div>
                    </nav>
                  </div>
                </div>


                <div class="mt-10 divide-y divide-gray-200">
                  <div class="space-y-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $props.data[selected].name }}</h3>
                    <p class="max-w-2xl text-sm text-gray-500">{{ $props.data[selected].description }}</p>
                    <p v-if="$props.errors" class="max-w-2xl text-md text-red-500">{{ $props.errors.value }}</p>
                  </div>
                  <div class="mt-6">
                    <dl class="divide-y divide-gray-200">
                      <!-- NOTE TITLE -->

                      <form v-for="(row, index) in $props.data[selected].system_settings" @submit.prevent="submit(row)" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500 h-[34px]">{{ row.name }}</dt>
                        <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                          <BasicTransition>
                            <AppInput
                              v-if="index == selectedData"
                              v-model="row.value"
                              :error="undefined"
                              :name="row.name"
                              size="sm"
                              type="text"
                              class="flex-grow rounded-xl h-8 active:ring-brand-400"
                            />
                            <span v-else class="flex-grow text-md" @click="selectedData = index">{{ row.value ?? 'N/A' }}</span>
                          </BasicTransition>
                          <span class="ml-4 flex-shrink-0">
                            <BasicTransition>
                              <AppButton v-if="index == selectedData" color="brand" size="sm" type="submit">Update</AppButton>
                              <PencilIcon v-else class="text-brand-400 group-hover:text-gray-500 mr-3 h-4 w-4" aria-hidden="true" />
                            </BasicTransition>

                          </span>
                        </dd>
                      </form>

                    </dl>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

</template>
