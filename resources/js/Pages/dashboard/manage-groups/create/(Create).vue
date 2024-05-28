<template>
  <div>
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      :form
      :heads="$page.props.auth ? [$page.props.auth] : []"
      :confirmButton="{
        text: 'Save',
        icon: PlusIcon
      }"
      @confirm="submit()"
    />

    <FlashErrors :errors="$page.props.errors" class="mt-4"/>

    <div class="grid grid-cols-4 gap-4">

      <div class="col-span-4 lg:col-span-1 mt-4">
        <CreateBasicCard v-model:name="form.name" v-model:description="form.description"/>
      </div>


      <div class="col-span-4 lg:col-span-1 mt-4">
        <CreateHeadsCard :users="filterUsers" v-model="invitedUsers"/>
      </div>

      <div class="col-span-4 lg:col-span-1 mt-4">
        <CreateMembersCard :users="filterUsers" v-model="invitedUsers"/>
      </div>

      <div class="col-span-4 lg:col-span-1 mt-4">
        <BasicCard :icon="InformationCircleIcon" title="Reminder" description="A reminder for inviting a members.">
          <p class="text-sm font-medium">How does invitation works?</p>
          <p class="text-sm text-brand-600 font-medium">You can search thru searchbox (in "Invite a member") and click the following user.</p>

          <p class="text-sm text-brand-600 mt-4 font-semibold">Cannot find the user?</p>
          <p class="text-sm text-yellow-700 font-medium">Once a member is assign to the role, they cannot assign to another role, hence it will not show to the search result.</p>
          <p class="text-sm text-yellow-700 font-medium">You must remove first the member to show in search result.</p>
        </BasicCard>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { TUser } from '@/globalTypes'
import { ref, computed } from 'vue'

import GroupHeader from '.././GroupHeader.vue'
import { PlusIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'
import FlashErrors from '@/components/header/FlashErrors.vue'
import SharedProps from '@/SharedProps'
import CreateBasicCard from './CreateBasicCard.vue'
import CreateMembersCard from './CreateMembersCard.vue'
import CreateHeadsCard from './CreateHeadsCard.vue'
import BasicCard from '@/components/cards/BasicCard.vue'

interface TUserWithParams extends TUser {
  disabled: boolean
  type: 'head' |'member'
}

const $props = defineProps<{
  users: TUserWithParams []
}>()
const $page = usePage<SharedProps>()

const form = router.form({
  name: '',
  description: '',
  avatar: '/assets/avatar_cover_default.jpg',
  cover: '/assets/cover_group_default.jpg',
})

const invitedUsers = ref<TUserWithParams []>($page.props.auth ? [{...$page.props.auth, disabled: true, type: 'head'}] : [])
const filterUsers = computed(() => {
  return $props.users.filter(({id: id1}) => !invitedUsers.value.some(({id: id2}) => id1 === id2))
})

function submit() {
  if(invitedUsers.value) {
    router.post('/dashboard/manage-groups', {
      name: form.name,
      description: form.description,
      // role: form.role.name,
      avatar: form.avatar,
      cover: form.cover,
      invitedUsers: Array.from(invitedUsers.value).map((row) => {
        return {
          id: row.id,
          type: row.type,
          disabled: row.disabled,
        }
      }),
    })
  }

}

</script>
