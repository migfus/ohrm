<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl mb-4 group">
    <div class="flex justify-between">
      <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          <AdjustmentsHorizontalIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
          Members
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Joined members list.</p>
      </div>
      <div class="">
        <PencilIcon class="text-sm text-brand-700 h-3 w-3 inline mr-1 mb-[3px] align-middle group-hover:opacity-100 transition-all sm:opacity-0"/>
      </div>
    </div>

    <div class="mt-4 border-t border-gray-100">
      <div class="divide-y divide-gray-100 flex gap-2 flex-col">
        <Link
          v-for="user in users"
          :href="`/dashboard/manage-users/${user.id}/edit`"
          class="bg-white pb-2 pt-1 px-4 rounded-full shadow text-nowrap"
        >
          <img :src="user.avatar" class="w-4 h-4 rounded-full inline"/>
          @{{ user.name }}
        </Link>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import { AdjustmentsHorizontalIcon, PencilIcon } from '@heroicons/vue/24/solid'

defineProps<{
  users: TUser[]
}>()
</script>
