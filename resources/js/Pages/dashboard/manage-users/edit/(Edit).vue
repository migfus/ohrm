<template>
  <div class="-mt-6 z-0">
    <ProfileHeader :user :authId="auth.id"/>
    <FlashErrors :errors class="mt-2" />

    <div class="grid grid-cols-4 mt-4 gap-4">
      <div class="col-span-4 md:col-span-2 lg:col-span-1">
        <UpdateBasicCard :user :errors class="mb-4"/>
        <UpdateSystemRole :roles :userRole="user.roles[0]" :userId="user.id"/>
        <!-- <OwnerCard v-if="user.roles_teams_head" :roles_teams_head="user.roles_teams_head" class="mb-4"/> -->
        <!-- <JoinedCard v-if="user.roles_teams" :roles_teams="user.roles_teams" class="mb-4"/> -->
      </div>
      <div class="col-span-4 md:col-span-2">
        <UserHeatMapCard />
      </div>
      <div class="col-span-1 md:col-span-2 lg:col-span-1">
        <JoinedGroupsCard :groupMembers="user.group_members" :userId="user.id"/>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TRole, TUser } from '@/globalTypes'

import ProfileHeader from '@/components/header/ProfileHeader.vue'

import UpdateBasicCard from './UpdateBasicCard.vue'
import OwnerCard from './OwnerCard.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'
import UpdateSystemRole from './UpdateSystemRole.vue'
import UserHeatMapCard from './UserHeatMapCard.vue'
import JoinedGroupsCard from './JoinedGroupsCard.vue'

defineProps<{
  user: TUser
  errors: Object
  auth: TUser
  roles: TRole []
}>()

</script>
