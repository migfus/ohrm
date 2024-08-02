<template>
  <div class="-mt-6 z-0">
    <ProfileHeader :user :authId="auth.id"/>
    <FlashErrors :errors class="mt-2" />

    <div class="grid grid-cols-4 mt-4 gap-4">
      <div class="col-span-4 md:col-span-2 lg:col-span-1">
        <UpdateBasicCard :user :errors class="mb-4"/>
        <UpdateSystemRole :roles :userRole="user.roles[0]" :userId="user.id"/>
        <!-- <JoinedCard v-if="user.roles_teams" :roles_teams="user.roles_teams" class="mb-4"/> -->
      </div>
      <div class="col-span-4 md:col-span-2 gap-4 flex flex-col">
        <UserHeatMapCard :task_activity :task_count_now/>
        <TasksCard />
        <PostSection />
      </div>
      <div class="col-span-4 sm:col-span-1 md:col-span-2 lg:col-span-1">
        <JoinedGroupsCard :groupMembers="user.group_members" :userId="user.id"/>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Role, User } from '@/globalTypes'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'


import ProfileHeader from '@/components/headers/ProfileHeader.vue'
import UpdateBasicCard from './UpdateBasicCard.vue'
import FlashErrors from '@/components/headers/FlashErrors.vue'
import UpdateSystemRole from './UpdateSystemRole.vue'
import UserHeatMapCard from './UserHeatMapCard.vue'
import JoinedGroupsCard from './JoinedGroupsCard.vue'
import TasksCard from './TasksCard.vue'
import PostSection from './PostsSection.vue'

defineProps<{
  user: User
  errors: Object
  auth: User
  roles: Role []
  task_activity: {
    date: string
    count: number
  }[]
  task_count_now: number
}>()

onErrorCaptured((e) => errorAlert('/dashboard/manage-users/edit/(Edit)', e))
</script>
