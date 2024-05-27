<template>
  <div>
    <NewGroupHeader v-model:avatar="form.avatar" v-model:cover="form.cover" :form @confirm="submit()"/>

    <FlashErrors :errors="$page.props.errors" class="mt-4"/>

    <div class="grid grid-cols-2 gap-4">

      <div class="col-span-3 lg:col-span-1 mt-4">
        <div class="rounded-xl bg-brand-50 shadow p-4">
          <div class="px-4 sm:px-0">
            <div class="flex justify-between">
              <h3 class="text-base font-semibold leading-7 text-gray-900">
                <AdjustmentsHorizontalIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
                Basic Information
              </h3>
            </div>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Basic information of the group.</p>

            <AppInput v-model="form.name" :error="form.errors.name" name="Group Name" size="sm" class="mt-3"/>
            <AppInput v-model="form.description" :error="form.errors.description" name="Description" size="sm" class="mt-3"/>
          </div>
        </div>
      </div>

      <div class="col-span-3 lg:col-span-1 mt-4">
        <div class="rounded-xl bg-brand-50 shadow p-4">
          <div class="px-4 sm:px-0">
            <div class="flex justify-between">
              <h3 class="text-base font-semibold leading-7 text-gray-900">
                <UsersIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
                Invite users
              </h3>
            </div>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">You can invite staff for your group.</p>


            <DataTransition>
              <UsersComboBox
                :users
                @selected="(v: TUser) => invitedUsers.add(v)"
                name="Users"
                class="my-3"
              />
            </DataTransition>

            <div class="flex flex-wrap gap-2">
              <BadgeContent v-for="user in invitedUsers" :avatar="user.avatar" :name="user.name" @remove="invitedUsers.delete(user)"/>
            </div>


          </div>
        </div>
      </div>


    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { TUser } from '@/globalTypes'
import { ref, watch } from 'vue'

import NewGroupHeader from './NewGroupHeader.vue'
import { AdjustmentsHorizontalIcon, UsersIcon} from '@heroicons/vue/24/outline'
import AppInput from '@/components/form/AppInput.vue'
import FlashErrors from '@/components/header/FlashErrors.vue'
import UsersComboBox from './UsersComboBox.vue'
import BadgeContent from '@/components/data/BadgeContent.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'

defineProps<{
  users: TUser []
}>()

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
