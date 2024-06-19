<template>
  <Link :href="`/dashboard/manage-groups/${data.id}/edit`" @click="loading = true" class="block hover:bg-white bg-brand-50 pb-4">
    <div class="flex items-center px-4 py-4 sm:px-6">
      <div class="flex min-w-0 flex-1 items-center">
        <div class="flex-shrink-0">
          <img class="h-12 w-12 rounded-xl" :src="data.avatar" alt="" />
        </div>
        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
          <div>
            <p class="truncate text-sm font-semibold text-brand-700">{{ data.name }}</p>
            <p class="mt-2 flex items-center text-sm text-brand-500 font-semibold">
              <span class="truncate">{{ data.description }}</span>
            </p>
          </div>
          <div class="hidden md:block">
            <div>
              <p class="text-sm text-gray-900">

              </p>

            </div>
          </div>
        </div>
      </div>
      <div>
        <ArrowPathIcon v-if="loading" class="animate-spin h-5 w-5 text-gray-400" aria-hidden="true" />
        <ChevronRightIcon v-else class="h-5 w-5 text-gray-400" aria-hidden="true" />
      </div>
    </div>

    <div class="flex mx-4 gap-2 flex-wrap">
      <!-- NOTE: ADMIN -->
      <div v-for="row in data.group_members_admin_only" :key="row.id">
        <Link
          v-if="row.user"
          :href="`/dashboard/manage-users/${row.user.id}/edit`"
          class="bg-brand-500 text-brand-50 text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium shadow"
        >
          <img :src="row.user.avatar" class="h-3 w-3 rounded-full"/>
          {{ row.user.name }}
        </Link>
      </div>


      <!-- NOTE: MEMBERS -->
      <div v-for="row in data.group_members_not_admin_only" :key="row.id">
        <Link
          v-if="row.user"
          :href="`/dashboard/manage-users/${row.user.id}/edit`"
          class="bg-white text-brand-700 text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium shadow"
        >
          <img :src="row.user.avatar" class="h-3 w-3 rounded-full"/>
          {{ row.user.name }}
        </Link>
      </div>

      <div
        v-if="data.group_members_not_admin_only.length > 5"
        class="bg-white text-brand-700 text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium shadow"
      >
        <UsersIcon class="h-4 w-4 text-brand-700" />
        {{ data.group_members_not_admin_only_count - data.group_members_admin_only.length}} More Members...
      </div>
    </div>
  </Link>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import { TGroup } from '@/globalTypes'
import { ChevronRightIcon, UsersIcon, ArrowPathIcon  } from '@heroicons/vue/20/solid'

const { data } = defineProps<{
  data: TGroup
}>()

const loading = ref<boolean>(false)
</script>
