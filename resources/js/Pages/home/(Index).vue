<template>
  <div class="my-4 flex flex-col gap-4">
    <BasicCard v-for="group in groups" :key="group.id" :icon="BriefcaseIcon" :title="group.name"></BasicCard>
  </div>

</template>

<script setup lang="ts">
import { TTeam } from '@/globalTypes'
import { BriefcaseIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'

defineProps<{
  groups: TTeam []
}>()
</script>
