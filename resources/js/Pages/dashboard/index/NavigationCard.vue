<template>
  <BasicCard :icon="ArrowRightCircleIcon" title="Navigation Shortcut">
    <div class="flex flex-wrap gap-2">
      <AppButton :icon="ArrowRightCircleIcon" :href="route('dashboard.my-groups.index')">My Groups</AppButton>
      <AppButton :icon="TicketIcon" :href="route('status.index')">Check Current Queuing</AppButton>
    </div>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import AppButton from '@/components/form/AppButton.vue'
import { ArrowRightCircleIcon, TicketIcon } from '@heroicons/vue/20/solid'
</script>
