<template>
  <div>
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      v-model:name="form.name"
      :confirmButton="{
        text: 'Save',
        icon: PlusIcon,
        color: 'brand'
      }"
      :admins="[{
        role: {
          id: '',
          name: '',
          description: '',
          display_name: '',
          created_at: '',
        },
        id: '',
        group_role_id: '',
        user: $page.props.auth!
      }]"
      @confirm="submit()"
    />

    <FlashErrors :errors="$page.props.errors" class="mt-4"/>

    <div class="grid grid-cols-3 mt-4 gap-4">
      <div class="col-span-3 lg:col-span-1">
        <CreateBasicCard v-model:name="form.name" v-model:description="form.description"/>
      </div>
      <div class="col-span-3 lg:col-span-2">
        <BasicCard
          :icon="QuestionMarkCircleIcon"
          title="Instruction"
          description="Read the instruction if you're new to the queuing system."
        >

          <div class="text-brand-700 mb-2">
            <p class="font-semibold">Avatar & Cover:</p>
            <p class="font-medium">
              <ComputerDesktopIcon class="h-4 w-4 mb-[4px] inline mr-1" />
              Avatar/Cover - click the image to change.
            </p>
          </div>

          <div class="text-brand-700 mb-2">
            <p class="font-semibold">Types of Members and Responsibilities:</p>
            <p class="font-medium">
              <StarIcon class="h-4 w-4 mb-[4px] inline mr-1" />
              Administrator - can manage all tasks-template/users/posts/group
            </p>
            <p class="font-medium">
              <UsersIcon class="h-4 w-4 mb-[4px] inline mr-1" />
              Moderator - can manage all tasks-template and delete posts
            </p>
            <p class="font-medium">
              <AtSymbolIcon class="h-4 w-4 mb-[4px] inline mr-1" />
              Member - can post and manage task given.
            </p>
          </div>

          <div class="text-brand-700">
            <p class="font-semibold">Others:</p>
            <p class="font-medium">
              <TicketIcon class="h-4 w-4 mb-[4px] inline mr-1" />
              Task Template - reference for a task that will be assign to members.
            </p>
            <p class="font-medium">
              <InboxArrowDownIcon class="h-4 w-4 mb-[4px] inline mr-1" />
              Task - assigned to a member and will be marked as completed/faile/expired
            </p>
            <p class="font-medium">
              <ChartBarIcon class="h-4 w-4 mb-[4px] inline mr-1" />
              Heatmap - group's tasks heatmap/activity.
            </p>
          </div>

        </BasicCard>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'

import GroupHeader from '.././GroupHeader.vue'
import {
  PlusIcon,
  QuestionMarkCircleIcon,
  StarIcon,
  AtSymbolIcon,
  UsersIcon,
  TicketIcon,
  ChartBarIcon,
  InboxArrowDownIcon,
  ComputerDesktopIcon
} from '@heroicons/vue/24/solid'
import FlashErrors from '@/components/header/FlashErrors.vue'
import SharedProps from '@/SharedProps'
import CreateBasicCard from './CreateBasicCard.vue'
import BasicCard from '@/components/cards/BasicCard.vue'

const $page = usePage<SharedProps>()

const form = router.form({
  name: '',
  description: '',
  avatar: '/assets/avatar_cover_default.jpg',
  cover: '/assets/cover_group_default.jpg',
})

function submit() {
  router.post('/dashboard/manage-groups', {
    name: form.name,
    description: form.description,
    avatar: form.avatar,
    cover: form.cover,
  })
}
</script>
