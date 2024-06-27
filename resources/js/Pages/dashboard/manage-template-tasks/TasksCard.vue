<template>
  <BasicCard :icon="TicketIcon" title="Tasks' Activity" description="Task">
    <div v-for="row in 10" class="bg-white mb-2 shadow rounded-2xl px-4 py-2">
      <div class="grid grid-cols-3 gap-4">
        <div class="font-medium">
          <div class="text-brand-700"><span class="text-sm text-brand-400">#20240602</span>-00{{ row }}</div>
          <div class="text-sm text-brand-500">
            <CheckCircleIcon class="w-4 h-4 inline mr-1 mb-[3px]" />
            Completed
          </div>
        </div>
        <div class="font-medium text-sm">
          <div class="text-brand-700 flex justify-start">
            <span class="truncate">{{ name }}</span>
          </div>
          <div class="text-sm text-brand-400  flex justify-start">
            <FolderMinusIcon class="w-4 h-4 inline mr-1 mb-[3px] rounded-full text-green-600" />
            Mid
          </div>
        </div>

        <div class="font-medium text-brand-600">
          <div class="justify-end text-sm hidden sm:flex">June 03, 2024 04:55 PM</div>
          <div class="flex justify-end text-sm sm:hidden">
            <span class="truncate">06/04/2024 04:55 PM</span>
          </div>
          <div class="text-sm flex justify-end ">
            <img src="https://w0.peakpx.com/wallpaper/991/370/HD-wallpaper-aang-fan-digital-art-avatar.jpg" class="w-3 h-3 inline mr-2 mt-[4px] rounded-full text-green-800" />
            <span class="truncate">Eunice Jane O. Sarausa</span>
          </div>
        </div>
      </div>
    </div>
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { TicketIcon, FolderMinusIcon, CheckCircleIcon } from '@heroicons/vue/24/solid'

defineProps<{
  name: string
}>()
</script>
