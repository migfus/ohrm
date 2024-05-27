<template>
  <BasicCard
    :icon="AdjustmentsHorizontalIcon"
    title="Create Basic Information"
    description="Provide a basic information of the group."
  >
    <div class="mb-4">
      <dd class="text-sm leading-6 text-gray-700 ">Name</dd>
      <BasicTransition>
        <div>
          <AppInput v-model="$modelName" size="sm" name="Name" :error="undefined" noLabel/>
        </div>
      </BasicTransition>
    </div>

    <div class="mb-4">
      <AppTextArea v-model="$modelDescription" name="Description"/>
    </div>
  </BasicCard>

</template>

<script setup lang="ts">
import AppInput from '@/components/form/AppInput.vue'
import BasicTransition from '@/components/transitions/BasicTransition.vue'
import AppTextArea from '@/components/form/AppTextArea.vue'
import { AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'

const $modelName = defineModel<string>('name')
const $modelDescription = defineModel<string>('description')
</script>
