<template>
  <Link
    :href="route('dashboard.manage-groups.edit', {manage_group: data.id})"
    @click="loading = true"
    class="block hover:bg-gray-50 bg-white rounded-2xl shadow"
  >
    <div class="flex justify-between p-4">

      <div class="flex gap-2 flex-grow truncate">
        <img class="h-12 w-12 rounded-xl flex-none" :src="data.avatar" alt="" />

        <div class="flex flex-col gap-1 truncate">
          <p class="truncate text-sm font-semibold text-brand-700 p-0 m-0">{{ data.name }}</p>
          <p class="flex items-center text-sm text-brand-500 font-semibold p-0 m-0">
            {{ data.description }}
          </p>
        </div>
      </div>

      <div class="p-4 flex-none w-5">
        <ArrowPathIcon v-if="loading" class="animate-spin h-5 mr-5 text-gray-400" aria-hidden="true" />
        <ChevronRightIcon v-else class="h-5 mr-5 text-gray-400" aria-hidden="true" />
      </div>
    </div>
  </Link>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Group } from '@/globalTypes'

import { ChevronRightIcon, ArrowPathIcon  } from '@heroicons/vue/20/solid'

const { data } = defineProps<{
  data: Group
}>()

const loading = ref<boolean>(false)
</script>
