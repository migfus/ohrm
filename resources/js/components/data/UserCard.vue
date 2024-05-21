<template>

    <Link :href="`/dashboard/manage-users/${data.id}/edit`" class="block hover:bg-white bg-brand-50 pb-4">
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
          <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </div>
      </div>

      <div class="flex mx-4 gap-2 flex-wrap">
        <span v-for="team in data.roles_teams" class="text-nowrap inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium text-gray-900 ring-1 bg-white shadow-sm ring-inset ring-gray-200">
          <svg class="h-1.5 w-1.5 fill-brand-500" viewBox="0 0 6 6" aria-hidden="true">
            <circle cx="3" cy="3" r="3" />
          </svg>
          {{  team.display_name }}
        </span>
      </div>
    </Link>

</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import moment from 'moment'
import { ChevronRightIcon } from '@heroicons/vue/20/solid'

const { data } = defineProps<{
  data: TUser
}>()
</script>
