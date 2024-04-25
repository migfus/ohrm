<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useTitle } from '@vueuse/core'
import { TProps } from '@/globalTypes'

import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'

interface TErrorWithTProps extends TProps {
  errors: {
    email: string | undefined
  }
}

const $props = defineProps<TErrorWithTProps>()
useTitle(`Forgot | ${$props.title}`)


const form = reactive<{ email: string }>({
  email: '',
})

function submit() {
  router.post('/forgot', form);
}
</script>

<template>

  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <object class="mx-auto h-12 w-auto" data="/assets/logo.svg" alt="Your Company" />
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-brand-800">Recover your account</h2>
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

          <div class="flex items-center justify-between">
            <div class="text-sm">
              <Link href="/login" class="font-medium text-brand-600 hover:text-brand-500">Need to login?</Link>
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
