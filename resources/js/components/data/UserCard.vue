<template>
  <Link :href="route('dashboard.manage-users.edit', { manage_user: data.id})" @click="loading = true" class="block hover:bg-white bg-brand-50 pb-4">
    <div class="flex items-center px-4 py-4 sm:px-6">
      <div class="flex min-w-0 flex-1 items-center">
        <div class="flex-shrink-0">
          <img class="h-12 w-12 rounded-full" :src="data.avatar" alt="" />
        </div>
        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
          <div>
            <p class="truncate text-sm font-semibold text-brand-700">{{ data.name }}</p>
            <p class="mt-2 flex items-center text-sm text-brand-500 font-semibold">
              <span class="truncate">{{ data.email }}</span>
            </p>
          </div>
          <div class="hidden md:block">
            <div>
              <p class="text-sm text-gray-900">
                Joined on
                {{ ' ' }}
                <time :datetime="data.created_at" class="font-medium">{{ moment(data.created_at).format('MMM DD, YYYY') }}</time>
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
      <Link
        v-for="row in data.group_members"
        :key="row.id"
        :href="route('dashboard.manage-groups.edit', { manage_group: row.id })"
        class="text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium text-gray-900 ring-1 bg-white shadow-sm ring-inset ring-gray-200"
      >
        <img :src="row.group?.avatar" class="h-3 w-3 rounded"/>
        {{ row.group?.name }}
      </Link>
    </div>
  </Link>
</template>

<script setup lang="ts">
import { User } from '@/globalTypes'
import moment from 'moment'
import { ref } from 'vue'

import { ChevronRightIcon, ArrowPathIcon } from '@heroicons/vue/20/solid'

defineProps<{
  data: User
}>()

const loading = ref<boolean>(false)
</script>
