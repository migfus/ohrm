<template>
  <BasicCard :icon="ArrowRightCircleIcon" title="Navigation Shortcut">
    <div class="flex flex-wrap gap-2">
      <AppButton :icon="ArrowRightCircleIcon" :href="route('dashboard.my-groups.index')">My Groups</AppButton>
      <AppButton :icon="TicketIcon" :href="route('status.index')">Check Current Queuing</AppButton>
      <AppButton :icon="PrinterIcon" :href="route('status.index')">Last Month Report</AppButton>
    </div>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import AppButton from '@/components/form/AppButton.vue'
import { ArrowRightCircleIcon, TicketIcon, PrinterIcon } from '@heroicons/vue/20/solid'
</script>
