<template>
  <ul role="list">
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
              v-for="user in row.users" :key="user.id"
              class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
              :src="user.avatar"
              :alt="`${user.name} Avatar`"
            />
          </div>
        </div>
        <div class="mx-4">
          <fieldset class="border-b border-t border-gray-200">
            <legend class="sr-only">Notifications</legend>
            <div class="divide-y divide-gray-200">

              <DataTransition>
                <div v-for="permission in permissions" :key="permission.id" class="relative flex items-start pb-4 pt-3.5">
                  <div class="min-w-0 flex-1 text-sm leading-6">
                    <label for="comments" class="font-medium text-gray-900">{{ permission.display_name }}</label>
                    <p id="comments-description" class="text-gray-500">{{ permission.description }}</p>
                  </div>
                  <div class="ml-3 flex h-6 items-center">
                    <input
                      :checked="row.permissions.filter(p => p.id === permission.id).length > 0 ? true : false"
                      :id="permission.name"
                      :aria-describedby="`${permission.name}-description`"
                      :name="permission.name"
                      type="checkbox"
                      class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-600"
                    />
                  </div>
                </div>
              </DataTransition>


            </div>
          </fieldset>
        </div>
      </li>
    </DataTransition>
  </ul>
</template>

<script setup lang="ts">
import { TPermission, TRole } from '@/globalTypes'

import DataTransition from '@/components/transitions/DataTransition.vue'

defineProps<{
  roles: TRole []
  permissions: TPermission []
}>()
</script>
