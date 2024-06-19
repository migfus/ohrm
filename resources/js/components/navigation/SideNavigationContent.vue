<template>
  <label class="ml-2 font-semibold text-brand-200">{{ title }}</label>
  <DataTransition>
    <Link
      v-for="(item, index) in data"
      :key="item.name"
      :href="item.href"
      @click="loadingAnimation(index)"
      :class="[
        item.components.some(row => row === $page.component) ?
          'bg-brand-200 text-brand-900 shadow' :
          'text-brand-100 hover:bg-brand-100 hover:text-gray-900',
          'group flex items-center px-2 py-2 text-sm font-medium rounded-2xl mb-1 pl-3'
      ]"
    >
      <!-- NOTE IF LOADING -->
      <ArrowPathIcon v-if="index == indexLoading" :class="['mr-3 h-5 w-5 animate-spin ']" aria-hidden="true" />
      <!-- NOTE IF ACTIVE -->
      <component v-else-if="item.components.some(row => row === $page.component)" :is="item.icon" class="text-brand-700 mr-3 h-5 w-5" aria-hidden="true" />
      <!-- NOTE IF DEFAULT -->
      <component v-else :is="item.icon" :class="['text-brand-100 group-hover:text-brand-700', 'mr-3 h-5 w-5']" aria-hidden="true" />
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
