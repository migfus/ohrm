<template>
  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img src="http://127.0.0.1:8000/assets/logo.png" class="mx-auto h-32 w-auto shadow-md rounded-2xl p-2" alt="OHRM Logo">
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-brand-800">Sign in to your account</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-brand-50 py-8 px-4 shadow sm:rounded-2xl sm:px-10">
        <FlashErrors :errors="$page.props.errors" />
        <!-- NOTE: FORM -->
        <form class="space-y-6" @submit.prevent="submit()">

          <AppInput
            v-model="form.email"
            :error="form.errors.email"
            name="Email"
            type="email"
            placeholder="Enter a email"
          />
          <AppInput
            v-model="form.password"
            :error="form.errors.password"
            type="password"
            name="Password"
            placeholder="Enter a password"
          />

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input v-model="form.remember" id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500" />
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>

            <div class="text-sm">
              <Link :href="route('forgot')" class="font-medium text-brand-600 hover:text-brand-500">Forgot your password?</Link>
            </div>
          </div>

          <div class="flex flex-col">
            <AppButton color="brand">
              Sign in
            </AppButton>
          </div>
        </form>

      </div>
    </div>

    <BasicCard :icon="HeartIcon" title="Select Account" description="Click the account to login" class="mt-4 max-w-md w-full mx-auto">
      <div class="flex flex-col gap-4">
        <AppButton
          name="admin"
          @click="changeAccount('admin@gmail.com', '#Admin.123')"
          :color="form.email == 'admin@gmail.com' ? 'brand' : ''"
        >
          admin@gmail.com
        </AppButton>
        <AppButton
          name="staff"
          @click="changeAccount('staff@gmail.com', '#Staff.123')"
          :color="form.email == 'staff@gmail.com' ? 'brand' : ''"
        >
          staff@gmail.com
        </AppButton>
      </div>
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import FlashErrors from '@/components/headers/FlashErrors.vue'
import BasicCard from '@/components/cards/BasicCard.vue'
import { HeartIcon } from '@heroicons/vue/24/solid'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  router.post(route('login.submit'), {
    email: form.email,
    password: form.password,
    remember: form.remember,
  });
}

function changeAccount(email: string, password: string ) {
  form.email = email
  form.password = password
}

onErrorCaptured((e) => errorAlert('/login/Login', e))
</script>
