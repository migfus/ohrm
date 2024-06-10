<template>

    <Link :href="`/dashboard/manage-groups/${data.id}/edit`" class="block hover:bg-white bg-brand-50 pb-4">
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
          <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </div>
      </div>

      <div class="flex mx-4 gap-2 flex-wrap">
        <Link
          v-for="row in data.group_members"
          :key="row.id"
          :href="`/dashboard/manage-users/${row.id}/edit`"
          :class="[row.role.name === 'admin' ? 'bg-brand-600 text-brand-50' : 'bg-white text-gray-900 ring-gray-200', 'text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium  ring-1 shadow-sm ring-inset ']"
        >
          <img :src="row.user.avatar" class="h-4 w-4 rounded-full"/>
          {{ row.user.name }}
        </Link>
      </div>
    </Link>

</template>

<script setup lang="ts">
import { TGroup } from '@/globalTypes'
import { ChevronRightIcon } from '@heroicons/vue/20/solid'

const { data } = defineProps<{
  data: TGroup
}>()
</script>
