<template>
  <div
    @click="checkIfActive"
    :class="[index == $model ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium cursor-pointer gap-2']"
    :aria-current="index == $model ? 'page' : undefined"
  >
    <ArrowPathIcon v-if="loading && disableLoading != true" class="h-4 w-4 animate-spin" aria-hidden="true" />
    <span v-else v-html="icon" class="h-4 w-4"></span>
    {{ display_name }}
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

import { ArrowPathIcon } from '@heroicons/vue/24/outline'

const $props = defineProps<{
  icon: string
  display_name: string
  index: number
  disableLoading?: boolean
}>()

const $model = defineModel<number>()

const loading = ref<boolean>(false)

router.on('finish',() => {
  loading.value = false
})

function checkIfActive() {
  if($props.index != $model.value) {
    loading.value = true
    $model.value = $props.index
  }
}
</script>
