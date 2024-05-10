<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl">
    <div class="px-4 sm:px-0">
      <h3 class="text-base font-semibold leading-7 text-gray-900">Basic Information</h3>
      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Modify basic information of the user.</p>
    </div>

    <div class="mt-6 border-t border-gray-100">
      <dl class="divide-y divide-gray-100">
        <div class="mb-4">
          <dd class="text-sm leading-6 text-gray-700">Name</dd>
          <BasicTransition>
            <form @submit.prevent="submit" v-if="active == 'name'" >
              <AppInput v-model="form.name" size="sm" name="Name" :error="undefined" noLabel/>
              <div class="flex justify-end gap-2 mt-2">
                <AppButton type="button" @click="cancel()" size="sm">Cancel</AppButton>
                <AppButton type="submit" size="sm" color="brand">Update</AppButton>
              </div>
            </form>
            <dt v-else @click="active = 'name'" class="text-sm font-medium leading-6 text-gray-900">{{ form.name }}</dt>
          </BasicTransition>
        </div>

        <div class="mb-4">
          <dd class="text-sm leading-6 text-gray-700">Email</dd>
          <BasicTransition>
            <form @submit.prevent="submit" v-if="active == 'email'" >
              <AppInput v-model="form.email" size="sm" name="Email" :error="undefined" noLabel/>
              <div class="flex justify-end gap-2 mt-2">
                <AppButton type="button" @click="cancel()" size="sm">Cancel</AppButton>
                <AppButton type="submit" size="sm" color="brand">Update</AppButton>
              </div>
            </form>
            <dt v-else @click="active = 'email'" class="text-sm font-medium leading-6 text-gray-900">{{ form.email }}</dt>
          </BasicTransition>
        </div>

        <div class="mb-4">
          <dd class="text-sm leading-6 text-gray-700">Password</dd>
          <BasicTransition>
            <form @submit.prevent="submit" v-if="active == 'password'" >
              <AppInput v-model="form.password" size="sm" name="Password" :error="undefined" noLabel/>
              <div class="flex justify-end gap-2 mt-2">
                <AppButton type="button" @click="cancel()" size="sm">Cancel</AppButton>
                <AppButton type="submit" size="sm" color="brand">Update</AppButton>
              </div>
            </form>
            <dt v-else @click="active = 'password'" class="text-sm font-medium leading-6 text-gray-900">{{ form.password }}</dt>
          </BasicTransition>
        </div>

      </dl>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { TUser } from '@/globalTypes'
import { router } from '@inertiajs/vue3'

import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import BasicTransition from '@/components/transitions/BasicTransition.vue'

const active = ref<string | null>(null)

const $props = defineProps<{
  user: TUser
}>()

const form = reactive({
  name: $props.user.name,
  email: $props.user.email,
  password: '*******************',
})

function cancel() {
  active.value = null
}

function submit() {
  active.value = null
  router.put(`/dashboard/manage-users/${$props.user.id}`, {
    type: 'basic',
    _name: $props.user.name,
    _email: $props.user.email,
    ...form
  })
}
</script>
