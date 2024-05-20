<template>
  <div class="-mt-6 z-0">
    <ProfileHeader :user :authId="auth.id"/>
    <FlashErrors :errors class="mt-2" />


    <div class="grid grid-cols-4 mt-4 gap-4">
      <div class="col-span-4 md:col-span-2 lg:col-span-1">
        <AboutCard :user :errors class="mb-4"/>
        <OwnerCard v-if="user.roles_teams_head" :roles_teams_head="user.roles_teams_head" class="mb-4"/>
        <JoinedCard v-if="user.roles_teams" :roles_teams="user.roles_teams" class="mb-4"/>
      </div>
      <div class="col-span-4 md:col-span-2">
        <HeatMapCard />
        <StatCard />
      </div>
      <div class="col-span-1 md:col-span-2 lg:col-span-1">
        <ActivityCard />
      </div>
    </div>


  </div>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'

import ProfileHeader from '@/components/profile/ProfileHeader.vue'
import ActivityCard from './ActivityCard.vue'
import AboutCard from './AboutCard.vue'
import JoinedCard from './JoinedCard.vue'
import OwnerCard from './OwnerCard.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'
import StatCard from './StatCard.vue'
import HeatMapCard from './HeatMapCard.vue'

defineProps<{
  user: TUser
  errors: Object
  auth: TUser
}>()

</script>
