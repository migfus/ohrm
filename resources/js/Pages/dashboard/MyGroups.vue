<template>
  <div>
    <BasicCard
      :icon="Square2StackIcon"
      title="Groups"
      description="My groups lists"
    >
      <DataTransition class="flex flex-col gap-2">
        <Link
          v-for="group in groups"
          :key="group.id"
          :href="route('dashboard.manage-groups.edit', { manage_group: group.id })"
          class="bg-white shadow rounded-2xl p-4 font-medium text-brand-700"
        >
          <div class="flex justify-between">
            <div>
              <img :src="group.avatar" alt="Group Avatar" class="h-6 w-6 inline rounded-full mr-1" />
              {{ group.name }}
            </div>
            <div class="text-sm text-brand-400">{{ dateTimeFormatted(group.created_at) }}</div>
          </div>
          <div class="flex justify-between">
            <div class="text-brand-400 text-sm ml-8 truncate">{{ group.description }}</div>
            <div v-if="group.group_members && group.group_members[0] ">
              <div class="text-brand-400 text-sm ml-8">as {{ group.group_members[0].role?.name }}</div>
            </div>

          </div>
        </Link>
      </DataTransition>

    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { Group } from '@/globalTypes'

import BasicCard from '@/components/cards/BasicCard.vue'
import { Square2StackIcon } from '@heroicons/vue/24/solid'
import { dateTimeFormatted } from '@/converter'
import DataTransition from '@/components/transitions/DataTransition.vue';

defineProps<{
  groups: Group[]
}>()
</script>
