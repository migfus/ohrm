<template>
  <div>
    <NewUserHeader v-model:avatar="form.avatar" v-model:cover="form.cover" :form @confirm="submit()"/>

    <FlashErrors :errors="$page.props.errors" class="mt-4"/>

    <div class="grid grid-cols-3 gap-4">

      <div class="col-span-3 lg:col-span-1 mt-4">
        <div class="rounded-xl bg-brand-50 shadow p-4">
          <div class="px-4 sm:px-0">
            <div class="flex justify-between">
              <h3 class="text-base font-semibold leading-7 text-gray-900">
                <AdjustmentsHorizontalIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
                Basic Information
              </h3>
            </div>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Basic information of the user.</p>

            <AppInput v-model="form.name" :error="form.errors.name" name="Name" size="sm" class="mt-3"/>
            <AppInput v-model="form.email" :error="form.errors.email" name="Email" size="sm" type="email" class="mt-3"/>
          </div>
        </div>
      </div>

      <div class="col-span-3 lg:col-span-1 mt-4">
        <div class="rounded-xl bg-brand-50 shadow p-4">
          <div class="px-4 sm:px-0">
            <div class="flex justify-between">
              <h3 class="text-base font-semibold leading-7 text-gray-900">
                <KeyIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
                Account Security
              </h3>
            </div>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Basic information of the user.</p>

            <AppInput v-model="form.password" :error="form.errors.password" name="Password" size="sm" class="mt-3"/>
            <!-- <AppInput v-model="form.confirm_password" :error="form.errors.confirm_password" name="Confirm Password" size="sm" type="password" class="mt-3"/> -->
          </div>
        </div>
      </div>

      <div class="col-span-3 lg:col-span-1 mt-4">
        <div class="rounded-xl bg-brand-50 shadow p-4">
          <div class="px-4 sm:px-0">
            <div class="flex justify-between">
              <h3 class="text-base font-semibold leading-7 text-gray-900">
                <ShieldCheckIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
                System Role
              </h3>
            </div>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Select a role for the user.</p>

            <ComboBox v-model="form.role" :data="roles" class="mt-3" name="Role"/>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'

import NewUserHeader from './NewUserHeader.vue'
import { AdjustmentsHorizontalIcon, ShieldCheckIcon, KeyIcon } from '@heroicons/vue/24/outline'
import AppInput from '@/components/form/AppInput.vue'
import ComboBox from '@/components/form/ComboBox.vue'
import { TRole } from '@/globalTypes'
import FlashErrors from '@/components/header/FlashErrors.vue'

const $props = defineProps<{
  roles: TRole []
}>()

const form = router.form({
  name: '',
  email: '',
  password: '',
  role: $props.roles[$props.roles.length - 1],
  avatar: '/assets/avatar_default.jpg',
  cover: '/assets/cover_default.jpg',
})

function submit() {
  router.post('/dashboard/manage-users', {
    name: form.name,
    email: form.email,
    password: form.password,
    role: form.role.name,
    avatar: form.avatar,
    cover: form.cover,
  })
}
</script>
