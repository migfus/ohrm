<template>

    <Link :href="`/dashboard/manage-groups/${data.id}/edit`" class="block hover:bg-white bg-brand-50 pb-4">
      <div class="flex items-center px-4 py-4 sm:px-6">
        <div class="flex min-w-0 flex-1 items-center">
          <div class="flex-shrink-0">
            <img class="h-12 w-12 rounded-full" :src="data.avatar" alt="" />
          </div>
          <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
            <div>
              <p class="truncate text-sm font-semibold text-brand-700">g/{{ data.display_name }}</p>
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
        <span v-for="user in data.heads" :key="user.id" class="text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium text-brand-50 bg-brand-400 shadow">
          <img :src="user.avatar" class="h-4 w-4 rounded-full"/>
          @{{ user.name }}
        </span>
        <span v-for="user in data.members" :key="user.id" class="text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium text-gray-900 ring-1 bg-white shadow-sm ring-inset ring-gray-200">
          <img :src="user.avatar" class="h-4 w-4 rounded-full"/>
          @{{ user.name }}
        </span>
      </div>
    </Link>

</template>

<script setup lang="ts">
import { TTeam } from '@/globalTypes'
import { ChevronRightIcon } from '@heroicons/vue/20/solid'

const { data } = defineProps<{
  data: TTeam
}>()
</script>
