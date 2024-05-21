<script setup lang="ts">
import { computed } from 'vue'

type TProps = {
  error: string | undefined
  name: string
  type?: 'text' | 'email' | 'password'
  placeholder?: string
  size?: 'sm'
  noLabel?: true | false
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

<template>
 <div>
  <div>
    <label v-if="!$props.noLabel">{{ $props.name }}</label>
    <input
      v-model="$model"
      :id="name"
      :name
      :type="type ?? 'text'"
      :placeholder="placeholder ?? ''"
      :class="[
        inputSize,
        error && 'border-red-500',
        'w-full rounded-xl border border-gray-300 placeholder-gray-400 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-brand-500'
      ]"
      autocomplete="off"
    />
    <label v-if="$props.error" for="password" class="block text-sm font-medium text-red-600">
      {{ $props.error }}
    </label>
  </div>
</div>
</template>

