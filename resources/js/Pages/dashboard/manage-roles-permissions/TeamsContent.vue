<template>
  <ul role="list">
    <DataTransition class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <li v-for="row in teams" :key="row.id" class="col-span-1 divide-y divide-gray-200 rounded-lg bg-brand-50 shadow">
        <div class="flex w-full items-center justify-between space-x-6 p-6">
          <div class="flex-1">
            <div class="flex items-center space-x-3">
              <h3 class="text-sm font-medium text-gray-900">{{ row.display_name }}</h3>
              <!-- <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ row.display_name }}</span> -->
            </div>
            <p class="mt-1 text-sm text-gray-500">{{ row.description }}</p>
          </div>
          <div class="flex -space-x-1 overflow-hidden">
            <div v-for="person in limitUsers(row.users)" :key="person.id">
              <img
                class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                :src="person.avatar"
                :alt="`${person.name} Avatar`"
              />
            </div>
            <div
              v-if="usersCount(row.users)"
              class="inline-block text-sm text-gray-600 pt-1 h-8 w-8 rounded-full ring-2 ring-white bg-white align-middle shadow"
            >
              +{{ usersCount(row.users) }}
            </div>
          </div>
        </div>

        <!-- NOTE: PEOPLE -->
        <ul role="list" class="divide-y divide-brand-100 overflow-hidden bg-bran-50 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <li v-for="person in row.users" :key="person.email" class="relative flex flex-col justify-between gap-x-6 px-4 py-5 hover:bg-white sm:px-6">
            <div class="flex justify-between">
              <div class="flex min-w-0 gap-x-4">
                <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="person.avatar" alt="" />
                <div class="min-w-0 flex-auto">
                  <p class="text-sm font-semibold leading-6 text-gray-900">
                    <a :href="person.id">
                      <span class="absolute inset-x-0 -top-px bottom-0" />
                      {{ person.name }}
                    </a>
                  </p>
                  <p class="mt-1 flex text-xs leading-5 text-gray-500">
                    <a :href="`mailto:${person.email}`" class="relative truncate hover:underline">{{ person.email }}</a>
                  </p>
                </div>
              </div>

              <div class="flex shrink-0 items-center gap-x-4">
                <div class="hidden sm:flex sm:flex-col sm:items-end">
                  <p v-if="person.created_at" class="mt-1 text-xs leading-5 text-gray-500">
                    Last seen <time :datetime="person.created_at">{{ moment(person.created_at).fromNow(true) }}</time>
                  </p>
                  <div v-else class="mt-1 flex items-center gap-x-1.5">
                    <div class="flex-none rounded-full bg-emerald-500/20 p-1">
                      <div class="h-1.5 w-1.5 rounded-full bg-emerald-500" />
                    </div>
                    <p class="text-xs leading-5 text-gray-500">Online</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- NOTE: ROLES -->
            <div class="flex mt-2 mb-0 gap-2">
              <span v-for="role in person.team_roles" class="bg-white flex-inline flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset ring-gray-200">
                <svg class="h-1.5 w-1.5 fill-brand-500" viewBox="0 0 6 6" aria-hidden="true">
                  <circle cx="3" cy="3" r="3" />
                </svg>
                {{ role.name }}
              </span>
            </div>

          </li>
        </ul>
      </li>
    </DataTransition>
  </ul>
</template>

<script setup lang="ts">
import { TTeam, TUser } from '@/globalTypes'
import moment from 'moment'
import { computed } from 'vue'

import DataTransition from '@/components/transitions/DataTransition.vue'

const $props = defineProps<{
  teams: TTeam[]
}>()

function limitUsers(users: TUser []) {
  return users.slice(0, 3)
}

function usersCount(users: TUser []) {
  if(users.length > 3) {
    return users.length - 3
  }
  else {
    return false
  }
}
</script>
