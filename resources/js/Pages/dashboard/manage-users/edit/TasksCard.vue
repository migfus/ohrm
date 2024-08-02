<template>
  <div>
    <BasicCard :icon="TicketIcon" title="Marked Tasks">
      Marked Tasks here
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { errorAlert } from '@/converter'
import { onErrorCaptured } from 'vue'

import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon } from '@heroicons/vue/24/solid'

onErrorCaptured((e) => errorAlert('/dashboard/manage-users/edit/TasksCard', e))
</script>
