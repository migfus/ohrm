<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl mb-4 group">
    <div class="flex justify-between">
      <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          <AdjustmentsHorizontalIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
          Change System Role
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">User role.</p>
      </div>
      <div class="">
        <PencilIcon class="text-sm text-brand-700 h-3 w-3 inline mr-1 mb-[3px] align-middle group-hover:opacity-100 transition-all sm:opacity-0"/>
      </div>
    </div>

    <div class="mt-4 border-t border-gray-100">
      <dl class="divide-y divide-gray-100">
        <Link
          v-for="team in roles_teams"
          :href="`/group/${team.id}`"
          class="resources/js/Pages/dashboard/manage-users/JoinedCard.vue"
        >
          {{ team.display_name }}
        </Link>

      </dl>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TTeam } from '@/globalTypes'
import { AdjustmentsHorizontalIcon, PencilIcon } from '@heroicons/vue/24/solid'

const roles_teams = [
  {
    id: 1,
    display_name: 'Unit Head'
  }
]
</script>
