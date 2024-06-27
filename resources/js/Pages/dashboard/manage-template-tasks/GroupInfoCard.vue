<template>
  <BasicCard :icon="SquaresPlusIcon" title="Group" description="Task template located">
    <Link :href="`/dashboard/manage-groups/${groupId}/edit`"  class="flex justify-between bg-white px-4 py-3 rounded-2xl shadow ">
      <div class="flex-grow">
        <img :src="avatar" class="h-4 w-4 inline mr-2 rounded mb-[2px]"/>
        <span class="font-medium">{{ name }}</span>
      </div>
      <ArrowLeftIcon class="w-4 h-4 mt-[4px]"/>
    </Link>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { SquaresPlusIcon, ArrowLeftIcon } from '@heroicons/vue/24/solid'

defineProps<{
  groupId: string
  name: string
  avatar: string
}>()
</script>

<style scoped>

</style>
