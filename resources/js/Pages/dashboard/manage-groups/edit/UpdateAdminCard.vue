<template>
  <BasicCard
    :icon="StarIcon"
    title="Admins"
    description="Users who administrate the group."
  >
    <DataTransition>
      <MemberDropdownMenu v-for="user in admins" :key="user.id" :id="user.id" @selected="RemoveMember(user.id)" :disabled="false">
        <div class="flex justify-start">
          <img :src="user.user.avatar" class="h-4 w-4 rounded-full inline mr-2 p-0 mt-[3px]">
          <span class="truncate">{{ user.user.name }}</span>
        </div>
      </MemberDropdownMenu>
    </DataTransition>


    <div class="flex flex-col">
      <UsersComboBox
        :groupId
        type="admin"
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
import { TGroupMember, TUser } from '@/globalTypes'
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

const $props = defineProps<{
  members: TGroupMember[]
  groupId: string
}>()

const removeOpen = ref<boolean>(false)
const selectedUser = ref<string>()
const admins = computed(() => $props.members.filter(user => user.role.name == 'admin'))

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
