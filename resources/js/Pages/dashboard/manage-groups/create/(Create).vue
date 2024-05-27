<template>
  <div>
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      :form
      :heads="[$page.props.auth]"
      :confirmButton="{
        text: 'Save',
        icon: PlusIcon
      }"
      @confirm="submit()"
    />

    <FlashErrors :errors="$page.props.errors" class="mt-4"/>

    <div class="grid grid-cols-4 gap-4">

      <div class="col-span-4 lg:col-span-1 mt-4">
        <CreateBasicCard :displayName="form.name" :description="form.description"/>
      </div>


      <div class="col-span-4 lg:col-span-2 mt-4">
        <!-- <CreateBasicCard :displayName="form.name" :description="form.description"/> -->
      </div>

      <div class="col-span-4 lg:col-span-1 mt-4">
        <CreateMembersCard :users="users" v-model="invitedUsers"/>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { TUser } from '@/globalTypes'
import { ref } from 'vue'

import GroupHeader from '.././GroupHeader.vue'
import { PlusIcon } from '@heroicons/vue/24/outline'
import FlashErrors from '@/components/header/FlashErrors.vue'
import SharedProps from '@/SharedProps'
import CreateBasicCard from './CreateBasicCard.vue'
import CreateMembersCard from './CreateMembersCard.vue'

defineProps<{
  users: TUser []
}>()
const $page = usePage<SharedProps>()

const form = router.form({
  name: '',
  description: '',
  avatar: '/assets/avatar_cover.jpg',
  cover: '/assets/cover_group.jpg',
})

const invitedUsers = ref<Set<TUser>>(new Set([]))

function submit() {
  router.post('/dashboard/manage-groups', {
    name: form.name,
    description: form.description,
    // role: form.role.name,
    avatar: form.avatar,
    cover: form.cover,
    invitedUsers: Array.from(invitedUsers.value).map(row => row.id),
  })
}

</script>
