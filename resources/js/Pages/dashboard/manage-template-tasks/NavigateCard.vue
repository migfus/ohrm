<template>
  <div>
    <BasicCard title="Navigate" :icon="ArrowLeftIcon" description="Navigation" :count="2">
      <div class="flex flex-col gap-2">
        <AppButton :href="route('index')" :icon="HomeIcon" class="text-left" alignment="l">
          Check Preview (Home Page)
        </AppButton>
        <AppButton :href="route('dashboard.manage-groups.edit', { manage_group: group.id })" :icon="ArrowLeftIcon" class="truncate">
          <img :src="group.avatar" class="inline h-5 w-5 rounded mr-2"/>
          <label class="truncate">
            {{ group.name }}
          </label>
        </AppButton>
      </div>
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'
import { Group } from '@/globalTypes'

import BasicCard from '@/components/cards/BasicCard.vue'
import { ArrowLeftIcon, HomeIcon } from '@heroicons/vue/20/solid'
import AppButton from '@/components/form/AppButton.vue'

defineProps<{
  group: Group
}>()

onErrorCaptured((e) => errorAlert('/dashboard/manage-template-tasks/NavigateCard', e))
</script>
