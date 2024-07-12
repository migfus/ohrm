<template>
  <FormModal
    :icon="SquaresPlusIcon"
    title="Create User"
    description="Create new user"
    mood="danger"
    v-model="$showCreateModalModel"
    size="max-w-md"
  >
    <FlashErrors :errors="$page.props.errors"/>

    <form @submit.prevent="submit()">
      <div class="flex flex-col mb-4 space-y-2">
        <AppInput name="Name" v-model="form.name" :error="form.errors.name"/>
        <AppInput name="Email" v-model="form.email" type="email" :error="form.errors.name"/>
        <AppInput name="Password" v-model="form.password" :error="form.errors.name"/>
        <AppSelect name="System Role"
          v-model="form.role"
          :suggestions="roles.map(role => {
            return {id: role.id, display_name: role.display_name}
          })"
        />
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
import { router } from '@inertiajs/vue3'
import FlashErrors from '@/components/header/FlashErrors.vue'
import AppSelect from '@/components/form/AppSelect.vue'
import { Select, Role } from '@/globalTypes'

const $showCreateModalModel = defineModel<boolean>()

const $props = defineProps<{
  roles: Role []
}>()

const form = router.form<{
  name: string
  email: string
  password: string
  role: Select
}>({
  name: '',
  email: '',
  password: '',
  role: {
    id: $props.roles[0].id,
    display_name: $props.roles[0].display_name,
  },
})

function submit() {
  router.post(route('dashboard.manage-users.store'), {
    name: form.name,
    email: form.email,
    password: form.password,
    roleId: form.role!.id
  },{
    preserveScroll: false,
    preserveState: false
  })
}
</script>
