<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl mb-4">
    <div class="flex justify-between">
      <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          <AdjustmentsHorizontalIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
          Group's Tasks
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Tasks for this group.</p>
      </div>
      <div class="">
        <PencilIcon class="text-sm text-brand-700 h-3 w-3 inline mr-1 mb-[3px] align-middle group-hover:opacity-100 transition-all sm:opacity-0"/>
      </div>
    </div>

    <div class="mt-4 border-t border-gray-100">
      <div class="divide-y divide-gray-100 flex gap-2 flex-col">
        <div
          v-for="user in users"
          :href="`/dashboard/manage-users/${user.id}/task/${user.id}`"
          class="bg-white pb-2 pt-1 px-4 rounded-full shadow group"
        >
          <Dropdown>
            <div class="flex justify-between">
              <div class="truncate">
                <img :src="user.avatar" class="w-4 h-4 rounded-full inline"/>
                @{{ user.name }}
              </div>
              <div>
                <EllipsisVerticalIcon class="text-sm text-brand-700 h-3 w-3 inline mb-[3px] align-middle group-hover:opacity-100 transition-all sm:opacity-0"/>
              </div>
            </div>
          </Dropdown>

        </div>
      </div>
    </div>

    <div class="flex justify-end">
      <AppButton color="brand" class="mt-2" :icon="PlusIcon" size="sm">Add Task</AppButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'

import { AdjustmentsHorizontalIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import AppButton from '@/components/form/AppButton.vue'
import { PlusIcon } from '@heroicons/vue/24/solid'
import Dropdown from './Dropdown.vue'

defineProps<{
  users: TUser[]
}>()
</script>
