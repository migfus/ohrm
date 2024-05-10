<template>
  <div class="-mt-6 z-0">
    <ProfileHeader :user/>
    <FlashErrors :errors class="mt-2" />


    <div class="grid grid-cols-4 mt-4 gap-4">
      <div class="col-span-4 sm:col-span-2 md:col-span-1">
        <AboutCard :user :errors class="mb-4"/>
        <JoinedCard class="mb-4"/>
        <OwnerCard class=""/>
      </div>
      <ActivityCard />
      <ActivityCard />
      <ActivityCard />
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

defineProps<{
  user: TUser
  errors: Object
}>()

</script>
