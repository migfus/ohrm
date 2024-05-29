<template>
  <BasicTransition>
    <div>
      <label v-if="!$props.noLabel" class="block text-sm font-medium leading-6 text-brand-700 mb-1">{{ $props.name }}</label>
      <input
        v-model="$model"
        :id="name"
        :name
        :type="type ?? 'text'"
        :placeholder="placeholder ?? ''"
        :class="[
          inputSize,
          injectCSS,
          error && 'border-red-500',
          'w-full rounded-2xl border border-gray-300 placeholder-gray-400 focus:border-brand-500 focus:outline-none focus:ring-brand-500 shadow-inner'
        ]"
        autocomplete="off"
      />
      <label v-if="$props.error" for="password" class="block text-sm font-medium text-red-600">
        {{ $props.error }}
      </label>
    </div>
  </BasicTransition>
</template>

<script setup lang="ts">
import { computed } from 'vue'

import BasicTransition from '../transitions/BasicTransition.vue'

type TProps = {
  error: string | undefined
  name: string
  type?: 'text' | 'email' | 'password'
  placeholder?: string
  size?: 'sm'
  noLabel?: true | false
  injectCSS?: string
}

const $props = defineProps<TProps>()
const $model = defineModel()

const inputSize = computed(() => {
  if(!$props.size) {
    return ''
  }
  else if($props.size == 'sm') {
    return 'text-sm h-[34px]'
  }
})

</script>
