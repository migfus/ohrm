<template>
  <div>
    <BasicCard
      :icon="Square2StackIcon"
      title="My Groups"
    >
      <AppInput name="Search" v-model="search_throttle" placeholder="Search" noLabel size="sm"/>

      <div v-if="groups.length <= 0">
        No group found.
      </div>

      <DataTransition v-else class="flex flex-col gap-2 mt-4">
        <Link
          v-for="group in groups"
          :key="group.id"
          :href="route('dashboard.manage-groups.edit', { manage_group: group.id })"
          class="bg-white shadow rounded-2xl p-4 font-medium text-brand-700"
        >
          <div class="flex justify-between">
            <div class="truncate">
              <img :src="group.avatar" alt="Group Avatar" class="h-6 w-6 inline rounded-full mr-1" />
              {{ group.name }}
            </div>
            <div class="text-sm text-brand-400 text-nowrap">{{ dateTimeFormatted(group.created_at) }}</div>
          </div>
          <div class="flex justify-between">
            <div class="text-brand-400 text-sm ml-8 truncate">{{ group.description }}</div>
            <div v-if="group.group_members && group.group_members[0] ">
              <div class="text-brand-400 text-sm ml-8">{{ upperCaseFirstChar(group.group_members[0].role?.name ?? '') }}</div>
            </div>
          </div>
        </Link>
      </DataTransition>

    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { Group } from '@/globalTypes'
import { ref, reactive, watch } from 'vue'
import { dateTimeFormatted, defaultRouterState, upperCaseFirstChar } from '@/converter'
import { router } from '@inertiajs/vue3'

import BasicCard from '@/components/cards/BasicCard.vue'
import { Square2StackIcon } from '@heroicons/vue/24/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'
import AppInput from '@/components/form/AppInput.vue'
import { useThrottle } from '@vueuse/core'

defineProps<{
  groups: Group[]
}>()

const search_throttle = ref('')
const form = reactive({
  search: useThrottle(search_throttle, 1000),
})

watch(form, () => {
  router.get(route('dashboard.my-groups.index'), { search: form.search }, defaultRouterState(['groups']))
})
</script>
