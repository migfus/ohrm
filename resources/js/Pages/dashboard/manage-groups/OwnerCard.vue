<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl mb-4 group">
    <div class="flex">
      <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          <StarIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
          Group Owner
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">A user who created this group.</p>
      </div>
    </div>

    <div class="mt-4 border-t border-gray-100">
      <dl class="divide-y divide-gray-100">
        <Link
          :href="`/dashboard/manage-users/${user.id}/edit`"
          class="bg-yellow-50 text-yellow-900 pb-2 pt-1 px-4 rounded-full shadow"
        >
          <img :src="user.avatar" class="w-4 h-4 rounded-full inline"/>
          @{{ user.name }}
        </Link>

      </dl>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import { StarIcon } from '@heroicons/vue/24/solid'

defineProps<{
  user: TUser
}>()
</script>
