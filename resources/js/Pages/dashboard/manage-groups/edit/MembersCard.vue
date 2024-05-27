<template>
  <div class="bg-brand-50 p-4 shadow rounded-2xl mb-4">
    <div class="flex justify-between mb-4">
      <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          <AtSymbolIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
          Members
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Tasks for this group.</p>
      </div>
    </div>

    <DataTransition>
      <MemberDropdown v-for="user in users" :key="user.id" :id="user.id" @selected="Selected">
        <div class="flex justify-start">
          <img :src="user.avatar" class="h-4 w-4 rounded-full inline mr-2 p-0 mb-[3px]">
          <span class="truncate">{{ user.name }}</span>
        </div>
      </MemberDropdown>
    </DataTransition>


    <div class="flex flex-col">
      <DataTransition>
        <UsersComboBoxIndividual
          :users
          @selected="(v: TUser) => invitedUsers.add(v)"
          name="Users"
          class="my-3"
        />
      </DataTransition>

      <AppButton color="brand" class="mt-2" :icon="PlusIcon" size="sm">Add Member</AppButton>
    </div>

    <RemovalPrompt v-model="removeOpen" @confirm="RemoveMember" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>
  </div>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

import { AtSymbolIcon, PlusIcon } from '@heroicons/vue/24/solid'
import AppButton from '@/components/form/AppButton.vue'
import MemberDropdown from './MemberDropdown.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'
import UsersComboBoxIndividual from './UsersComboBoxIndividual.vue'

const $props = defineProps<{
  members: TUser[]
  users: TUser[]
  id: string
}>()

const removeOpen = ref<boolean>(false)
const selectedUserId = ref<string>('')
const invitedUsers = ref<Set<TUser>>(new Set([]))

function Selected(value: {type: string, id: string}) {
  switch(value.type) {
    case 'edit':
      alert('edit' + value.id)
      break;
    case 'remove':
      removeOpen.value = true
      selectedUserId.value = value.id
      break;
    default:
      alert('edit'  + value.id)
  }
}

function RemoveMember() {
  removeOpen.value = false

  router.put(`/dashboard/manage-groups/${$props.id}`, {
    type: 'remove-member',
    memberId: selectedUserId.value
  }, {
    preserveScroll: true, preserveState: true
  })
}
</script>
