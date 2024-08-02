<template>
  <BasicCard
    :iconHtml="groupRole.hero_icon.content"
    :title="groupRole.display_name"
    :description="groupRole.description"
    :count="filtered_members.length"
  >
    <DataTransition>
      <MemberDropdownMenu
        v-for="member in filtered_members"
        :key="member.id"
        :id="member.id"
        :userId="member.user_id"
        :disabled="(filtered_members.length <= 1 && groupRole.display_name == 'Administrator') || groupRole.display_name == 'Removed'"
        @selected="RemoveMember(member.id)"
      >
        <div class="flex justify-start">
          <img :src="member?.user?.avatar" class="h-4 w-4 rounded-full inline mr-2 p-0 mt-[3px]">
          <span :class="[groupRole.display_name == 'Removed' && 'line-through', 'truncate']">{{ member?.user?.name }}</span>
        </div>
      </MemberDropdownMenu>
    </DataTransition>


    <div v-if="groupRole.display_name != 'Removed'" class="flex flex-col">
      <UsersComboBox
        :groupId
        type="admin"
        name="Users"
        class="my-3"
        label="Invite a heads"
        @addMember="AddMember"
      />
    </div>

    <RemovalPrompt v-model="remove_open" @confirm="ConfirmRemove" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>
  </BasicCard>
</template>

<script setup lang="ts">
import { GroupMember, GroupRole, User } from '@/globalTypes'
import { ref, computed, onErrorCaptured } from 'vue'
import { router } from '@inertiajs/vue3'
import { defaultRouterState, errorAlert } from '@/converter'

import MemberDropdownMenu from '.././MemberDropdownMenu.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'
import UsersComboBox from '.././UsersComboBox.vue'
import BasicCard from '@/components/cards/BasicCard.vue'

const $props = defineProps<{
  groupId: string
  groupRole: GroupRole
  groupMembers: GroupMember[]
}>()

const remove_open = ref<boolean>(false)
const selected_member_id = ref<string>()
const filtered_members = computed<GroupMember[]>(() => {
  return $props.groupMembers.filter(user => user.group_role_id == $props.groupRole.id)
})

function RemoveMember(id: string) {
  remove_open.value = true
  selected_member_id.value = id
}

function ConfirmRemove() {
  router.put(
    route('dashboard.manage-groups.update', { manage_group: $props.groupId }), {
      member_id: selected_member_id.value,
      type: 'remove-member',
    },
    defaultRouterState(['group_members'])
  )
}

function AddMember(user: User) {
  router.put(
    route('dashboard.manage-groups.update', { manage_group: $props.groupId }), {
      user_id: user.id,
      type: 'add-member',
      roleId: $props.groupRole.id
    },
    defaultRouterState(['group_members'])
  )
}

onErrorCaptured((e) => errorAlert('/dashboard/manage-groups/edit/UpdateMembersCard', e))
</script>
