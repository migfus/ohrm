<template>
  <BasicCard :icon="SquaresPlusIcon" title="Joined Groups" description="User's joined groups">
    <GroupDropdownMenu v-for="member in groupMembers" id="1">
      <div class="flex">
        <img :src="member.group?.avatar ?? ''" class="h-3 w-3 mt-1 rounded mr-2" />
        <span class="truncate">{{ member.group?.name }}</span>
        <ChevronDownIcon
          class="h-6 w-6"
          aria-hidden="true"
        />
      </div>
      <div class="flex justify-end mr-4">{{ member.role?.display_name }}</div>
    </GroupDropdownMenu>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { SquaresPlusIcon } from '@heroicons/vue/24/outline'
import GroupDropdownMenu from '../GroupDropdownMenu.vue'
import { TGroupMember } from '@/globalTypes'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'

defineProps<{
  groupMembers?: TGroupMember []
}>()
</script>
