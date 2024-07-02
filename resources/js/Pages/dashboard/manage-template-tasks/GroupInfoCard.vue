<template>
  <BasicCard :icon="SquaresPlusIcon" title="Group" description="Task template located">

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
