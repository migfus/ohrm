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
        <CreateBasicCard :displayName="form.name" :description="form.description"/>
      </div>


      <div class="col-span-4 lg:col-span-1 mt-4">
        <CreateHeadsCard :users="filterUsers" v-model="invitedUsers"/>
      </div>

      <div class="col-span-4 lg:col-span-2 mt-4">
        <CreateMembersCard :users="filterUsers" v-model="invitedUsers"/>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { TUser } from '@/globalTypes'
import { ref, computed } from 'vue'

import GroupHeader from '.././GroupHeader.vue'
import { PlusIcon } from '@heroicons/vue/24/outline'
import FlashErrors from '@/components/header/FlashErrors.vue'
import SharedProps from '@/SharedProps'
import CreateBasicCard from './CreateBasicCard.vue'
import CreateMembersCard from './CreateMembersCard.vue'
import CreateHeadsCard from './CreateHeadsCard.vue'

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
  avatar: '/assets/avatar_cover.jpg',
  cover: '/assets/cover_group.jpg',
})

const invitedUsers = ref<TUserWithParams []>($page.props.auth ? [{...$page.props.auth, disabled: true, type: 'head'}] : [])
const filterUsers = computed(() => {
  return $props.users.filter((row) => !invitedUsers.value.includes(row))
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
          row: row.id,
          type: row.type,
          disabled: row.disabled,
        }
      }),
    })
  }

}

</script>
