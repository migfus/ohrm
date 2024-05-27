<template>
  <BasicCard
    :icon="AtSymbolIcon"
    title="Members"
    description="List of staff that has access to this group."
  >
    <DataTransition>
      <MemberDropdownMenu v-for="user in $model" :key="user.id" :id="user.id" @selected="RemoveMember(user)">
        <div class="flex justify-start">
          <img :src="user.avatar" class="h-4 w-4 rounded-full inline mr-2 p-0 mb-[3px]">
          <span class="truncate">{{ user.name }}</span>
        </div>
      </MemberDropdownMenu>
    </DataTransition>


    <div class="flex flex-col">
      <DataTransition>
        <UsersComboBox
          :users
          @selected="(v: TUser) => $model?.add(v)"
          name="Users"
          class="my-3"
        />
      </DataTransition>
    </div>

    <RemovalPrompt v-model="removeOpen" @confirm="ConfirmRemove" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>
  </BasicCard>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import { ref } from 'vue'

import { AtSymbolIcon } from '@heroicons/vue/24/solid'
import MemberDropdownMenu from '.././MemberDropdownMenu.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'
import UsersComboBox from '.././UsersComboBox.vue'
import BasicCard from '@/components/cards/BasicCard.vue'

const $model = defineModel<Set<TUser>>()
defineProps<{
  users: TUser[]
}>()

const removeOpen = ref<boolean>(false)
const selectedUser = ref<TUser>()

function RemoveMember(user: TUser) {
  removeOpen.value = true
  selectedUser.value = user
}
function ConfirmRemove() {
  if(selectedUser!.value) {
    $model.value?.delete(selectedUser!.value)
  }
}
</script>
