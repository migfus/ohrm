<template>
  <BasicCard :icon="TicketIcon" title="Recent Tasks" description="Task">
    <DataTransition>
      <div v-for="row in tasks" :key="row.id" class="bg-white mb-2 shadow rounded-2xl px-4 py-2">
        <Link class="grid grid-cols-1 sm:grid-cols-3 gap-4" :href="`/dashboard/manage-template-tasks/${row.task_template.id}/edit`">
          <div class="flex justify-between font-medium">
            <div class="">
              <div class="text-brand-700">
                <span class="text-sm text-brand-400">#{{ row.id.toString().substring(0, 6) }}</span>-{{ row.id.toString().substring(6) }}
              </div>

              <div class="text-sm text-brand-500">
                <div v-html="row.task_status.hero_icon.content" class="w-4 h-4 inline-block pt-[3px] mr-1 text-brand-600"></div>
                <span class="inline">{{ row.task_status.name }} </span>
              </div>

            </div>

            <div class="flex sm:hidden text-brand-500">
              <div class="justify-end text-sm hidden sm:flex">{{ moment(row.created_at).format('MMM DD, YYYY hh:mm A') }}</div>
              <div class="flex justify-end text-sm sm:hidden">
                <span class="truncate">{{ moment(row.created_at).format('MM/DD/YYYY hh:mm A') }}</span>
              </div>
            </div>

          </div>

          <div class="font-medium text-sm">
            <div class="text-brand-700 flex justify-start">
              <span class="truncate">{{ row.task_template.name }}</span>
            </div>
            <div class="text-sm text-brand-400  flex justify-start mt-1">
              <div v-html="row.task_priority.hero_icon.content" class="w-4 h-4 inline mr-1 mt-[2px] rounded-full text-brand-600"></div>
              {{ row.task_priority.name }}
            </div>
          </div>

          <div class="font-medium text-brand-600">
            <div class="hidden sm:flex justify-end">
              <div v-if="moment().format('YYYYMMDD') == moment(row.created_at).format('YYYYMMDD')" class="justify-end text-sm hidden sm:flex">{{ moment(row.created_at).format('hh:mm A') }}</div>
              <div v-else class="justify-end text-sm hidden sm:flex">{{ moment(row.created_at).format('MMM DD, YYYY hh:mm A') }}</div>
              <div class="flex justify-end text-sm sm:hidden">
                <span v-if="moment().format('YYYYMMDD') == moment(row.created_at).format('YYYYMMDD')" class="truncate">{{ moment(row.created_at).format('hh:mm A') }}</span>
                <span v-else class="truncate">{{ moment(row.created_at).format('MM/DD/YYYY hh:mm A') }}</span>
              </div>
            </div>

            <!-- USER ASSIGN/ED -->
            <div v-if="row.task_user_access" class="text-sm flex justify-end mt-1">
              <img :src="row.task_user_access.user.avatar" class="w-3 h-3 inline mr-2 mt-[4px] rounded-full text-green-800" />
              <span class="truncate">{{ row.task_user_access.user.name }}</span>
            </div>
            <div v-else class="text-sm flex sm:justify-end mt-1" >
              <QuestionMarkCircleIcon class="w-4 h-4 inline mr-2 mt-[2px] rounded-full text-green-800" />
              <span class="truncate">Unassigned</span>
            </div>
          </div>

          <div v-if="row.message" class="flex bg-brand-50 px-4 py-2 rounded-2xl col-span-3 text-sm">
            {{ row.message }}
          </div>
        </Link>
      </div>
    </DataTransition>
    <DataTransition class="flex gap-2 justify-end mt-4">
      <AppButton
        v-for="temp in taskTemplates"
        :name="`${temp.name} button`"
        class="unwrap"
        noLoading
        :href="route('dashboard.manage-template-tasks.edit', {manage_template_task: temp.id})"
      >
        {{ temp.name }}
      </AppButton>
    </DataTransition>

  </BasicCard>
</template>

<script setup lang="ts">
import moment from 'moment'
import { Task, TaskTemplate } from '@/globalTypes'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon, QuestionMarkCircleIcon } from '@heroicons/vue/24/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'
import AppButton from '@/components/form/AppButton.vue'

defineProps<{
  tasks: Task[]
  taskTemplates: TaskTemplate[]
}>()
</script>
