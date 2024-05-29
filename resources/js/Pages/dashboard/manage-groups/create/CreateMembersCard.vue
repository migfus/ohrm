<template>
  <BasicCard
    :icon="AtSymbolIcon"
    title="Members"
    description="List of staff that has access to this group."
  >
    <MemberDropdownMenu
      v-for="user in filteredUsers"
      :key="user.id"
      :id="user.id"
      :disabled="user.disabled"
      @selected="RemoveMember(user.id)"
    >
      <div class="flex justify-start">
        <img :src="user.avatar" class="h-4 w-4 rounded-full inline mr-2 p-0 mb-[3px]">
        <span class="truncate">{{ user.name }}</span>
      </div>
    </MemberDropdownMenu>

    <div class="flex flex-col">
      <UsersComboBox
        v-model="$invitedUsersModel"
        type="member"
        name="Users"
        class="my-3"
      />
    </div>

    <RemovalPrompt v-model="removeOpen" @confirm="ConfirmRemove" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>
  </BasicCard>
</template>

<script setup lang="ts">
import { TUser, TUserWithType } from '@/globalTypes'
import { ref, computed } from 'vue'

import { AtSymbolIcon } from '@heroicons/vue/24/solid'
import MemberDropdownMenu from '.././MemberDropdownMenu.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import UsersComboBox from '.././UsersComboBox.vue'
import BasicCard from '@/components/cards/BasicCard.vue'

const $invitedUsersModel = defineModel<TUserWithType[]>()

const removeOpen = ref<boolean>(false)
const selectedUser = ref<TUser>()
const filteredUsers = computed(() => {
  if($invitedUsersModel.value) {
    return Array.from($invitedUsersModel.value.filter(user => user.type == 'member'))
  }
  return null
})

function RemoveMember(id: string) {
  if($invitedUsersModel.value !== undefined) {
    removeOpen.value = true
    selectedUser.value = $invitedUsersModel.value?.find(user => user.id === id)
  }
}
function ConfirmRemove() {
  if(selectedUser!.value !== undefined) {
    const index = $invitedUsersModel.value?.findIndex(user => user.id === selectedUser.value!.id) as number
    $invitedUsersModel.value?.splice(index, 1)
  }
}
</script>
