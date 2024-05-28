<template>
  <BasicCard
    :icon="StarIcon"
    title="Heads"
    description="List of staff that has access to this group."
  >
    <DataTransition>
      <MemberDropdownMenu v-for="user in filteredUsers" :key="user.id" :id="user.id" @selected="RemoveMember(user.id)" :disabled="user.disabled">
        <div class="flex justify-start">
          <img :src="user.avatar" class="h-4 w-4 rounded-full inline mr-2 p-0 mb-[3px]">
          <span class="truncate">{{ user.name }}</span>
        </div>
      </MemberDropdownMenu>
    </DataTransition>


    <div class="flex flex-col">
      <UsersComboBox
        :users
        @selected="(v: TUserWithParams) => $model?.push({...v, type:'head' } as TUserWithParams)"
        name="Users"
        class="my-3"
        label="Invite a heads"
      />
    </div>

    <RemovalPrompt v-model="removeOpen" @confirm="ConfirmRemove" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>
  </BasicCard>
</template>

<script setup lang="ts">
import { TUser } from '@/globalTypes'
import { ref, computed } from 'vue'

import { StarIcon } from '@heroicons/vue/24/solid'
import MemberDropdownMenu from '.././MemberDropdownMenu.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'
import UsersComboBox from '.././UsersComboBox.vue'
import BasicCard from '@/components/cards/BasicCard.vue'

const $model = defineModel<TUserWithParams []>()

interface TUserWithParams extends TUser {
  disabled: boolean
  type: 'head' |'member'
}
defineProps<{
  users: TUserWithParams[]
}>()

const removeOpen = ref<boolean>(false)
const selectedUser = ref<string>()
const filteredUsers = computed(() => {
  if($model.value) {
    const arrayUser = Array.from($model.value)
    return new Set(arrayUser.filter(user => user.type ==='head'))
  }
  return null
})

function RemoveMember(id: string) {
  removeOpen.value = true
  selectedUser.value = id
}
function ConfirmRemove() {
  if(selectedUser!.value !== undefined) {
    const index = $model.value?.findIndex(user => user.id === selectedUser.value) as number
    $model.value?.splice(index, 1)
  }
}
</script>
