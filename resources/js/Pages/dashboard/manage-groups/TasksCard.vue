<template>
  <div class="bg-brand-50 p-4 shadow rounded-2xl mb-4">
    <div class="flex justify-between mb-4">
      <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          <AdjustmentsHorizontalIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
          Group's Tasks
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Tasks for this group.</p>
      </div>
    </div>

    <TaskDropdown v-for="user in users" :key="user.id">
      <span>{{ user.name }}</span>
    </TaskDropdown>

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
import TaskDropdown from './TaskDropdown.vue'

defineProps<{
  users: TUser[]
}>()
</script>
