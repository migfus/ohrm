<template>
  <BasicCard :icon="SquaresPlusIcon" title="Joined Groups" description="User's joined groups">
    <GroupDropdownMenu v-for="member in groupMembers" :id="member.id" :groupId="member.group_id" @selected="selected(member.id)">
      <div class="flex justify-between">
        <img :src="member.group?.avatar ?? ''" class="h-3 w-3 mt-1 rounded mr-2" />
        <span class="grow flex truncate">
          <span class="truncate">
            {{ member.group?.name }}
          </span>
        </span>
        <ChevronDownIcon
          class="h-5 w-5"
          aria-hidden="true"
        />
      </div>
      <div class="flex justify-end mr-4">
        <div v-html="member.role?.hero_icon.content" class="h-3 w-3 mt-[4px] mr-1"></div>
        {{ member.role?.display_name }}
      </div>
    </GroupDropdownMenu>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { SquaresPlusIcon } from '@heroicons/vue/24/outline'
import GroupDropdownMenu from '../GroupDropdownMenu.vue'
import { GroupMember } from '@/globalTypes'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { router } from '@inertiajs/vue3'

const $props = defineProps<{
  groupMembers?: GroupMember []
  userId: string
}>()

function selected(id: string) {
  router.put(route('dashboard.manage-users.update', { manage_user: $props.userId}), {
    type: 'remove-joined-group',
    group_member_id: id
  })
}
</script>
