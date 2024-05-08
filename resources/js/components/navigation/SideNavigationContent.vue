<template>
  <label class="ml-2 font-semibold text-gray-500">{{ title }}</label>
  <DataTransition>
    <Link v-for="(item, index) in data" :key="item.name" :href="item.href" @click="loadingAnimation(index)" :class="[item.href == $page.url ? 'bg-brand-100 text-brand-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
      <ArrowPathIcon v-if="index == indexLoading" class="text-gray-500 mr-3 h-6 w-6 animate-spin" aria-hidden="true" />
      <component v-else-if="item.href == $page.url" :is="item.icon" class="text-gray-500 mr-3 h-6 w-6" aria-hidden="true" />
      <component v-else :is="item.icon" :class="['text-brand-400 group-hover:text-gray-500', 'mr-3 h-6 w-6']" aria-hidden="true" />
      <div class="truncate">{{ item.name }}</div>
    </Link>
  </DataTransition>

</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { TCTopNavigation } from '@/globalTypes'

import { ArrowPathIcon } from '@heroicons/vue/24/outline'
import DataTransition from '../transitions/DataTransition.vue'
import BasicTransition from '../transitions/BasicTransition.vue'

defineProps<{
  title: string
  data: TCTopNavigation[]
}>()
const $model = defineModel<boolean>()

const indexLoading = ref<number | null>(null)

router.on('finish',() => {
  indexLoading.value = null
  $model.value = false
})

function loadingAnimation(index: number) {
  indexLoading.value = index
}
</script>
