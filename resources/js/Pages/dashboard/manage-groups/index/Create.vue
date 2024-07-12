<template>
  <FormModal
      :icon="SquaresPlusIcon"
      title="Create Group"
      description="Create new group"
      mood="danger"
      v-model="$showCreateModalModel"
      size="max-w-md"
    >
      <FlashErrors :errors="$page.props.errors"/>
      <form @submit.prevent="submit()">
        <div class="flex flex-col mb-4">
          <AppInput name="Name" v-model="form.name" :error="form.errors.name"/>
          <AppTextArea name="Description" v-model="form.description" :error="form.errors.description"/>
        </div>
        <div class="flex flex-col sm:flex-row-reverse justify-start space-y-2 sm:space-y-0 sm:space-x-2">
          <AppButton :icon="PlusIcon" color="brand" type="submit" class="sm:ml-2">Create</AppButton>
          <AppButton :icon="XMarkIcon" @click="$showCreateModalModel = false" type="button" color="danger">Cancel</AppButton>
        </div>
      </form>

    </FormModal>
</template>

<script setup lang="ts">
import FormModal from '@/components/modals/FormModal.vue'
import { PlusIcon, XMarkIcon, SquaresPlusIcon } from '@heroicons/vue/24/solid'
import AppButton from '@/components/form/AppButton.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppTextArea from '@/components/form/AppTextArea.vue'
import { router } from '@inertiajs/vue3'
import FlashErrors from '@/components/header/FlashErrors.vue'

const $showCreateModalModel = defineModel<boolean>()

const form = router.form({
  name: '',
  description: ''
})

function submit() {
  router.post(route('dashboard.manage-groups.index'), {
    name: form.name,
    description: form.description
  })
}
</script>
