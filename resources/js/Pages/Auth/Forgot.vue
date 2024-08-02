<template>
  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img src="http://127.0.0.1:8000/assets/logo.png" class="mx-auto h-32 w-auto bg-white shadow-md rounded-2xl px-2 py-2" alt="OHRM Logo" />
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-brand-800">Recover your account</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-brand-50 py-8 px-4 shadow sm:rounded-2xl sm:px-10">
        <!-- NOTE: FORM -->
        <form class="space-y-6" @submit.prevent="submit()">

          <AppInput
            v-model="form.email"
            :error="$props.errors.email"
            name="Email"
            type="email"
            placeholder="Enter a email"
          />

          <div class="flex items-center justify-between">
            <div class="text-sm">
              <Link :href="route('login')" class="font-medium text-brand-600 hover:text-brand-500">Need to login?</Link>
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

<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3'
import { Props } from '@/globalTypes'
import { onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'

interface TErrorWithTProps extends Props {
  errors: {
    email: string | undefined
  }
}

const $props = defineProps<TErrorWithTProps>()

const form = useForm({
  email: '',
})

function submit() {
  router.post(route('forgot.submit'), {
    email: form.email
  });
}

onErrorCaptured((e) => errorAlert('/forgot/Forgot', e))
</script>
