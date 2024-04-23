<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'

import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'

const $props = defineProps<{
  errors: {
    email: string | undefined
    password: string | undefined
    remember: string | undefined
  }
}>()

type TForm = {
  email: string
  password: string
  remember: boolean,
  _token: string
}

const form = reactive<TForm>({
  email: 'admin@gmail.com',
  password: '#Admin.123',
  remember: false,
  _token: $props.csrf_token,
})



function submit() {
  router.post('/login', form);
}
</script>

<template>

  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <object class="mx-auto h-12 w-auto" data="/assets/logo.svg" alt="Your Company" />
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-brand-800">Sign in to your account</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-brand-50 py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="submit()">


          <AppInput
            v-model="form.email"
            :error="$props.errors.email"
            name="Email"
            type="email"
            placeholder="Enter a email"
          />
          <AppInput
            v-model="form.password"
            :error="$props.errors.password"
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
              <Link href="/forgot" class="font-medium text-brand-600 hover:text-brand-500">Forgot your password?</Link>
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
  </div>
</template>
