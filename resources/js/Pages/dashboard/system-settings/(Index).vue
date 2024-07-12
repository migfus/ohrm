<template>
  <div>
    <UploadAvatarModal
      v-model="$props.data[selected].system_settings[selectedData ?? 0].value"
      v-model:show="uploadAvatarOpen"
      :size="[100, 100]"
      :ratio="1"
      name="Upload Avatar"
    />
    <div class="flex flex-col max-w-7xl md:px-8 xl:px-0 mx-4">
      <main class="flex-1">
        <div class="relative mx-auto md:px-8 xl:px-0">
          <div class="pb-16">

            <!-- NOTE: HEADER -->
            <HeaderContent title="System Settings" desc="Tweak your prefered settings for the system."/>

            <!-- NOTE: CONTENT -->
            <div class="px-4 sm:px-6 md:px-0">
              <div class="">

                <!-- NOTE TABS -->
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
                    <DataTransition class="-mb-px flex space-x-8">
                      <div
                        v-for="(tab, index) in $props.data"
                        :key="tab.name"
                        @click="selected = index"
                        :class="[
                          selected == index ?
                            'border-brand-500 text-brand-600' :
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                          'cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex']"
                        >
                        <span v-html="tab.icon" class="h-4 w-4 mr-2 -ml-1 pt-0.5"></span>
                        {{ tab.name }}
                    </div>
                    </DataTransition>
                  </div>
                </div>

                <!-- NOTE DATA -->
                <div class="bg-brand-50 p-4 rounded-2xl shadow mt-4">
                  <div class="space-y-1">
                    <!-- NOTE ERRORS -->
                    <div v-if="$page.props.errors!.value" class="rounded-md bg-red-50 p-4">
                      <div class="flex">
                        <div class="flex-shrink-0">
                          <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                          <h3 class="text-sm font-medium text-red-800">There were 1 error submission</h3>
                          <div class="mt-2 text-sm text-red-700">
                            <ul role="list" class="list-disc space-y-1 pl-5">
                              <li>{{ $page.props.errors!.value }}</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="mt-6">
                    <DataTransition class="divide-y divide-gray-200">
                      <!-- NOTE TITLE -->

                      <form
                        v-for="(row, index) in $props.data[selected].system_settings"
                        @submit.prevent="submit(row)"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5"
                      >
                        <dt class="text-sm font-medium text-gray-500">{{ row.name }}</dt>
                        <dd class="mt-1 flex justify-between text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                          <BasicTransition>
                            <!-- NOTE INPUT -->
                            <div v-if="index == selectedData && row.system_setting_type.name == 'text'" class="mb-6 w-full flex flex-col gap-2">
                              <AppInput
                                v-model="row.value"
                                :error="undefined"
                                :name="row.name"
                                size="sm"
                                type="text"
                              />
                              <div class="flex justify-end">
                                <AppButton
                                  color="brand"
                                  size="sm"
                                  type="submit"
                                >
                                  Update
                                </AppButton>
                              </div>
                            </div>


                            <!-- NOTE PREVIEW -->
                            <img
                              v-else-if="row.system_setting_type.name == 'avatar'"
                              @click="selectedData = index; uploadAvatarOpen = true"
                              :src="row.value"
                              class="text-md h-10 w-10 shadow"
                            />
                            <span v-else class="flex-grow text-md" @click="selectedData = index">{{ row.value ?? 'N/A' }}</span>
                          </BasicTransition>
                          <span class="ml-4 flex-shrink-0">
                            <BasicTransition>
                              <!-- NOTE AVATAR -->
                              <PencilIcon
                                v-if="row.system_setting_type.name == 'avatar'"
                                @click="selectedData = index; uploadAvatarOpen = true"
                                class="text-brand-400 group-hover:text-gray-500 mr-3 h-4 w-4"
                                aria-hidden="true"
                              />
                              <!-- NOTE TEXT -->
                              <PencilIcon
                                v-else
                                @click="selectedData = index"
                                class="text-brand-400 group-hover:text-gray-500 mr-3 h-4 w-4"
                                aria-hidden="true"
                              />
                            </BasicTransition>

                          </span>
                        </dd>
                      </form>

                    </DataTransition>
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

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

import AppButton from '@/components/form/AppButton.vue'
import AppInput from '@/components/form/AppInput.vue'
import { PencilIcon, XCircleIcon } from '@heroicons/vue/24/outline'
import BasicTransition from '@/components/transitions/BasicTransition.vue'
import UploadAvatarModal from '@/components/modals/UploadAvatarModal.vue'
import HeaderContent from '@/components/header/HeaderContent.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'

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
  icon: string
  description: string
  href: string
  system_settings: TSystemSettings []
}

const $props = defineProps<{
  data: TData[]
}>()

const selected = ref(0)
const selectedData = ref<number | null>(null)
const uploadAvatarOpen = ref(false)

function submit(row: TSystemSettings) {
  router.put(route('dashboard.system-settings.update', { system_setting: row.id}),
    {
      value: row.value,
      type: row.system_setting_type.name
    }
  )
  selectedData.value = null
}
</script>
