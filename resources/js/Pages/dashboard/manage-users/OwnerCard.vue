<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl mb-4">
    <div class="px-4 sm:px-0">
      <h3 class="text-base font-semibold leading-7 text-gray-900">
        <StarIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
        Teams Owned (Head)
      </h3>
      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">User that responsibled for created teams.</p>
    </div>
    <div class="mt-6 border-t border-gray-100">
      <dl class="divide-y divide-gray-100">
        <Link
          v-for="team in roles_teams_head"
          :href="`/group/${team.id}`"
          class="text-sm font-medium text-gray-900 hover:bg-white hover:shadow transition-all block p-2 rounded-xl"
        >
          {{ team.display_name }}
        </Link>
      </dl>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TTeam } from '@/globalTypes'

import { StarIcon } from '@heroicons/vue/24/solid'

defineProps<{
  roles_teams_head: TTeam[]
}>()
</script>
