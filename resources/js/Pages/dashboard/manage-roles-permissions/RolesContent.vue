<template>
  <ul role="list">
    <FlashErrors :errors/>
    <DataTransition class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <li v-for="row in roles" :key="row.id" class="col-span-1 divide-y divide-gray-200 rounded-lg bg-brand-50 shadow">
        <div class="flex w-full items-center justify-between space-x-6 p-6">
          <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
              <h3 class="truncate text-sm font-medium text-gray-900">{{ row.display_name }}</h3>
              <!-- <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ row.display_name }}</span> -->
            </div>
            <p class="mt-1 truncate text-sm text-gray-500">{{ row.description }}</p>
          </div>
          <div class="flex -space-x-1 overflow-hidden">
            <img
              v-for="user in limitUsers(row.users)" :key="user.id"
              class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
              :src="user.avatar"
              :alt="`${user.name} Avatar`"
            />

            <span v-if="usersCount(row.users)" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-400">
              <span class="text-xs font-medium leading-none text-white">+{{  usersCount(row.users) }}</span>
            </span>

          </div>
        </div>
        <div class="mx-4">
          <fieldset class="border-b border-t border-gray-200">
            <legend class="sr-only">Notifications</legend>
            <div class="divide-y divide-gray-200">

              <DataTransition>
                <RoleRow v-for="permission in permissions" :key="permission.id" :data="permission" :row/>
              </DataTransition>


            </div>
          </fieldset>
        </div>
      </li>
    </DataTransition>
  </ul>
</template>

<script setup lang="ts">
import { TPermission, TRole, TUser } from '@/globalTypes'
import { ref } from 'vue'

import DataTransition from '@/components/transitions/DataTransition.vue'
import RoleRow from './RoleRow.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'

defineProps<{
  roles: TRole []
  permissions: TPermission []
  errors: object
}>()
const loadingIndex = ref<number | null>(null)

function usersCount(users: TUser []) {
  if(users.length > 3) {
    return users.length - 3
  }
  else {
    return false
  }
}

function limitUsers(users: TUser []) {
  return users.slice(0, 3)
}


</script>
