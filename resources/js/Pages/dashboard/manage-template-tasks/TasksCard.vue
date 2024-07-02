<template>
  <BasicCard :icon="TicketIcon" title="Tasks' Activity" description="Task">
    <div v-for="row in tasks" class="bg-white mb-2 shadow rounded-2xl px-4 py-2">
      <div class="grid grid-cols-3 gap-4">
        <div class="font-medium">
          <div class="text-brand-700">
            <span class="text-sm text-brand-400">#{{ row.id.toString().substring(0, 6) }}</span>-{{ row.id.toString().substring(6) }}
          </div>
          <div class="text-sm text-brand-500">
            <div v-html="row.task_status.hero_icon.content" class="w-4 h-4 inline-block pt-[3px] mr-1 text-brand-600"></div>
            <span class="inline">{{ row.task_status.name }}</span>
          </div>
        </div>
        <div class="font-medium text-sm">
          <div class="text-brand-700 flex justify-start">
            <span class="truncate">{{ name }}</span>
          </div>
          <div class="text-sm text-brand-400  flex justify-start mt-1">
            <div v-html="row.task_priority.hero_icon.content" class="w-4 h-4 inline mr-1 mt-[2px] rounded-full text-brand-600"></div>
            {{ row.task_priority.name }}
          </div>
        </div>

        <div class="font-medium text-brand-600">
          <div class="justify-end text-sm hidden sm:flex">{{ moment(row.created_at).format('MMM DD, YYYY hh:mm A') }}</div>
          <div class="flex justify-end text-sm sm:hidden">
            <span class="truncate">{{ moment(row.created_at).format('MM/DD/YYYY hh:mm A') }}</span>
          </div>
          <div class="text-sm flex justify-end mt-1">
            <img :src="row.task_user_assigns.user.avatar" class="w-3 h-3 inline mr-2 mt-[4px] rounded-full text-green-800" />
            <span class="truncate">{{ row.task_user_assigns.user.name }}</span>
          </div>
        </div>
      </div>
    </div>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { TTask } from '@/globalTypes'
import { TicketIcon } from '@heroicons/vue/24/solid'
import moment from 'moment'

defineProps<{
  name: string
  tasks: TTask []
}>()
</script>
