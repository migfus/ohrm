<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl">
    <div class="px-4 sm:px-0">
      <h3 class="text-base font-semibold leading-7 text-gray-900">Joined Teams</h3>
      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">User that joined teams with.</p>
    </div>
    <div class="mt-4 border-t border-gray-100">
      <dl class="divide-y divide-gray-100">
        <Link
          v-for="team in roles_teams"
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

defineProps<{
  roles_teams: TTeam[]
}>()
</script>
