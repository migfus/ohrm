<template>
  <BasicCard
    :iconHtml="icon"
    :title="name"
    :description
  >
    <DataTransition>
      <MemberDropdownMenu
        v-for="member in filteredMembers"
        :key="member.id"
        :id="member.id"
        :disabled="filteredMembers.length <= 1 && name == 'Administrators'"
        @selected="RemoveMember(member.id)"
      >
        <div class="flex justify-start">
          <img :src="member.user.avatar" class="h-4 w-4 rounded-full inline mr-2 p-0 mt-[3px]">
          <span class="truncate">{{ member.user.name }}</span>
        </div>
      </MemberDropdownMenu>
    </DataTransition>


    <div class="flex flex-col">
      <UsersComboBox
        :groupId
        type="admin"
        name="Users"
        class="my-3"
        label="Invite a heads"
        @addMember="AddMember"
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
import { router } from '@inertiajs/vue3'

import { AtSymbolIcon } from '@heroicons/vue/24/solid'
import MemberDropdownMenu from '.././MemberDropdownMenu.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'
import UsersComboBox from '.././UsersComboBox.vue'
import BasicCard from '@/components/cards/BasicCard.vue'

const $props = defineProps<{
  members: TGroupMember[]
  groupId: string
  roleId: string
  name: string
  icon: string
  description: string
}>()

const removeOpen = ref<boolean>(false)
const selectedMemberId = ref<string>()
const filteredMembers = computed<TGroupMember[]>(() => {
  return $props.members.filter(user => user.group_role_id == $props.roleId)
})

function RemoveMember(id: string) {
  removeOpen.value = true
  selectedMemberId.value = id
}

function ConfirmRemove() {
  router.put(`/dashboard/manage-groups/${$props.groupId}`, {
    memberId: selectedMemberId.value,
    type: 'remove-member',
  }, {
    preserveScroll: true,
    preserveState: true
  })
}

function AddMember(user: TUser) {
  router.put(`/dashboard/manage-groups/${$props.groupId}`, {
    user_id: user.id,
    type: 'add-member',
    roleId: $props.roleId
  }, {
    preserveScroll: true,
    preserveState: true
  })
}
</script>
