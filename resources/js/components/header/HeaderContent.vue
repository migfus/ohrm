<template>
  <div class="border-b border-gray-200 pb-5 mb-4 flex-inline sm:flex justify-between">
    <div class="">
      <h1 class="text-semibold font-semibold text-gray-900 text-xl">{{ title }}</h1>
      <p class="mt-2 max-w-4xl text-sm text-gray-500">{{ desc }}</p>
    </div>

    <div v-if="allowSearch" class="mt-3 flex">
      <AppButton @click="add()" color="brand" class="pt-3 mr-1" :icon="PlusIcon">Add</AppButton>
      <AppInput v-model="$model" :error="undefined" name="Search" placeholder="Search" noLabel class="flex-grow"/>
    </div>

  </div>
</template>

<script setup lang="ts">
import AppInput from '../form/AppInput.vue'
import AppButton from '../form/AppButton.vue'
import { PlusIcon } from '@heroicons/vue/24/outline'

const $model = defineModel<string>()
const $emit = defineEmits(['add'])

defineProps<{
  title: string
  desc: string
  allowSearch?: boolean
}>()

function add() {
  $emit('add', true)
}
</script>
