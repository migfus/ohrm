<template>
  <BasicCard title="Create Post" :icon="ChatBubbleOvalLeftIcon" description="Creat Post to this group.">
    <div class="flex flex-col">
      <AppButton name="Post" :icon="ChatBubbleOvalLeftIcon" @click="openCreatPostModal = true">Add Post</AppButton>
    </div>
  </BasicCard>

  <FormModal
    v-model="openCreatPostModal"
    title="Create new Post"
    description="Create new post for this group."
    :icon="ChatBubbleOvalLeftIcon"
    size="max-w-lg"
  >
    <QuillEditor v-model:content="form.content" theme="snow" :toolbar/>

    <div class="flex justify-end mt-4 gap-2">
      <AppButton name="Post" @click="openCreatPostModal = false" :icon="XMarkIcon">Cancel</AppButton>
      <AppButton name="Post" @click="submitPost()" color="brand" :icon="PaperAirplaneIcon">Post</AppButton>
    </div>

    <!-- <div v-html="quillContentToHtml(form.content)"></div> -->
  </FormModal>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

import BasicCard from '@/components/cards/BasicCard.vue'
import { ChatBubbleOvalLeftIcon, PaperAirplaneIcon, XMarkIcon } from '@heroicons/vue/24/solid'
import AppButton from '@/components/form/AppButton.vue'
import FormModal from '@/components/modals/FormModal.vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const openCreatPostModal = ref(false)

const toolbar = {
  container: [
    ['bold', 'italic', 'underline','strike', 'blockquote'],
    [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
    ['link', 'image', 'video'],
    ['clean']
  ]
}
const $props = defineProps<{
  groupId: string
}>()

const form = router.form({
  content: ''
})

function submitPost() {
  router.put(`/dashboard/manage-groups/${$props.groupId}`, {
    // @ts-ignore
    content: form.content.ops,
    type: 'post'
  }, {
    preserveScroll: true,
    preserveState: true
  })
  openCreatPostModal.value = false
  form.reset()
}
</script>

<style>
.ql-toolbar{
  background-color: #fff !important;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
  box-shadow: #000;
}
.ql-container {
  background-color: #fff !important;
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
}
.ql-container.ql-snow {
  border: 0px solid #fff !important;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}
.ql-toolbar.ql-snow  {
  border: 0px 0px 1px 0px solid #818181 !important;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}
.ql-editor {
  min-height: 100px !important;
}
</style>
