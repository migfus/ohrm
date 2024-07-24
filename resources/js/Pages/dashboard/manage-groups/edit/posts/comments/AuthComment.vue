<template>
  <div class="pb-4 px-4">
    <div class="flex">
      <img :src="$auth.avatar" class="h-7 w-7 rounded-full mt-[11px] mr-2"/>
      <AppTextArea v-model="form.content" name="Comment" noLabel :lines="String(lines)" placeholder="Write a comment" class="flex-grow transition-all" @click="lines = 2"/>
    </div>
    <div v-if="lines > 1" class="flex justify-end mt-2 gap-2">
      <AppButton :icon="XMarkIcon" name="Comment" size="sm" @click="form.reset(); lines = 1">Cancel</AppButton>
      <AppButton :icon="ChatBubbleLeftIcon" name="Comment" size="sm" color="brand" @click="submitComment()">Comment</AppButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import { User } from '@/globalTypes'
import { ref }  from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

import AppTextArea from '@/components/form/AppTextArea.vue'
import AppButton from '@/components/form/AppButton.vue'
import { ChatBubbleLeftIcon, XMarkIcon } from '@heroicons/vue/24/solid'

defineProps<{
  post_id: string
}>()

const $page = usePage()
const $auth = $page.props.auth as User
const lines = ref(1)
const form = useForm({
  content: '',
})

const $emit = defineEmits(['submitNewComment'])

function submitComment() {
  $emit('submitNewComment', form.content)
  lines.value = 1
  form.reset()
}
</script>
