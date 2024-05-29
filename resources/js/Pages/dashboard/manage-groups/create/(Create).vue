<template>
  <div>
    <GroupHeader
      v-model:avatar="form.avatar"
      v-model:cover="form.cover"
      v-model:name="form.name"
      :heads="invitedUsers.filter(user => user.type == 'head')"
      :confirmButton="{
        text: 'Save',
        icon: PlusIcon
      }"
      @confirm="submit()"
    />

    <FlashErrors :errors="$page.props.errors" class="mt-4"/>

    <div class="grid grid-cols-4 gap-4">

      <div class="col-span-4 lg:col-span-2 xl:col-span-1 mt-4">
        <CreateBasicCard v-model:name="form.name" v-model:description="form.description"/>
      </div>


      <div class="col-span-4 lg:col-span-2 xl:col-span-1 mt-4">
        <CreateHeadsCard v-model="invitedUsers"/>
      </div>

      <div class="col-span-4 lg:col-span-2 xl:col-span-1 mt-4">
        <CreateMembersCard v-model="invitedUsers"/>
      </div>

      <div class="col-span-4 lg:col-span-2 xl:col-span-1 mt-4">
        <CreateTasksCard v-model="form.tasks"/>
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
import CreateHeadsCard from './CreateHeadsCard.vue'
import CreateTasksCard from './CreateTasksCard.vue'

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
  tasks: [],
})

const invitedUsers = ref<TUserWithParams []>($page.props.auth ? [{...$page.props.auth, disabled: true, type: 'head'}] : [])

function submit() {
  if(invitedUsers.value) {
    router.post('/dashboard/manage-groups', {
      name: form.name,
      description: form.description,
      // role: form.role.name,
      avatar: form.avatar,
      cover: form.cover,
      tasks: form.tasks,
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
