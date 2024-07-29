<template>
  <div>
    <BasicCard title="Latest Posts" :icon="PencilSquareIcon" class="mb-4">
      <AppInput v-model="search_throttle" name="Search" noLabel placeholder="Search" />
    </BasicCard>

      <div v-if="posts.length <= 0">
        No post available.
      </div>

      <DataTransition v-else class="flex flex-col gap-2">
        <div v-for="row in posts" :key="row.id" class="bg-brand-50 rounded-2xl shadow p-4">
          <div class="flex justify-between font-medium text-sm">
            <div>
              <img :src="row.user.avatar" class="h-6 w-6 rounded-full inline mr-2"/>
              <label class="">{{ row.user.name }}</label>
            </div>
            <label class="text-brand-500">{{ dateTimeFormatted(row.created_at) }}</label>
          </div>
          <div class="mt-2 shadow rounded-2xl p-4 bg-white">{{ row.title }}</div>
        </div>
      </DataTransition>


  </div>
</template>

<script setup lang="ts">
import { ref, watch, reactive } from 'vue'

import BasicCard from '@/components/cards/BasicCard.vue'
import { PencilSquareIcon } from '@heroicons/vue/24/solid'
import AppInput from '@/components/form/AppInput.vue'
import { useThrottle } from '@vueuse/core'
import { router } from '@inertiajs/vue3'
import { dateTimeFormatted, defaultRouterState } from '@/converter'
import { Post } from '@/globalTypes'
import DataTransition from '@/components/transitions/DataTransition.vue'

defineProps<{
  posts: Post[]
}>()
const search_throttle = ref('')

const form = reactive({
  search: useThrottle(search_throttle, 2000),
})

watch(form, () => {
  router.get(route('dashboard.my-groups.index'), {}, defaultRouterState(['posts']))
})
</script>
