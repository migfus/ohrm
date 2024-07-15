<template>
  <div class="bg-brand-50 shadow sm:rounded-2xl text-brand-800">
    <!-- NOTE: POSTCARD HEADER -->
    <div class="flex font-medium justify-between px-4 pt-4 pb-2">
      <Link :href="route('dashboard.manage-users.edit', {manage_user: post.user.id})" class="flex">
        <img :src="$props.post.user.avatar" class="h-8 w-8 rounded-full shadow mr-2" />
        <div class="flex flex-col">
          <span class="text-sm">{{ $props.post.user.name }}</span>
          <span class="text-xs">{{ dateTimeFormatted($props.post.created_at) }}</span>
        </div>
      </Link>
      <div class="text-sm font-regular py-0 my-0 cursor-pointer flex">
        <MapPinIcon v-if="$props.post.is_pinned" class="h-4 w-4 mt-[2px] text-brand-500 cursor-default"/>
        <PostDropown @click="dropDownEmit" :isPinned="$props.post.is_pinned"/>
      </div>
    </div>

    <!-- NOTE: POSTCARD CONTENTS -->
    <div ref="sentenceLines" class="m-1 bg-white px-4 py-2 rounded-lg mx-4 shadow font-medium">
      <div v-if="minimize_content" v-html="$props.post.title" class="line-clamp-4" ></div>
      <div v-else v-html="$props.post.title"></div>

      <MultimediaPostFormatter
        v-if="$props.post.post_type.name == 'Multimedia'"
        :contents="$props.post.post_contents"
        :counts="$props.post.post_contents_count"
      />

      <div v-else-if="$props.post.post_type.name == 'Documents'">[Post Type Documents]</div>
    </div>



    <button v-if="height > 95" class="mx-4 text-sm" @click="minimize_content = !minimize_content">{{ minimize_content ? 'Show More...' : 'Show Less...'}}</button>

    <!-- NOTE: POSTCARD FOOTER -->
    <div class="flex justify-between mx-4 py-2 text-sm gap-4">
      <span class="text">😅</span>
      <span class="cursor-pointer">{{ contentFormatter('Comment', $props.post.comments_count) }}</span>
    </div>

    <!-- NOTE: COMMENTS -->
    <DataTransition class="mx-4 flex flex-col gap-2">
      <CommentContent v-for="comment in post.comments" :key="comment.id" :comment :postId="post.id"/>
    </DataTransition>

    <!-- NOTE: AUTH COMMENT -->
    <PostCommentCard :postId="$props.post.id" :groupId/>

  </div>
</template>

<script setup lang="ts">
import { ref, } from 'vue'
import { useElementSize } from '@vueuse/core'
import { Post } from '@/globalTypes'
import axios from 'axios'
import { contentFormatter, dateTimeFormatted } from '@/converter'

import { MapPinIcon } from '@heroicons/vue/24/solid'
import PostCommentCard from './PostCommentCard.vue'
import CommentContent from './CommentContent.vue'
import PostDropown from './PostDropown.vue'
import DataTransition from '../transitions/DataTransition.vue'
import MultimediaPostFormatter from './MultimediaPostFormatter.vue'

const $props = defineProps<{
  groupId: string
  post: Post
  index: number
}>()

const $emit = defineEmits(['removePost', 'updatedPost', 'editPost'])

const minimize_content = ref(true)
const sentence_lines = ref(null)
const { height } = useElementSize(sentence_lines)

// NOTE: Emits from Dropdown
function dropDownEmit(value: string) {
  switch(value) {
    case 'edit':
      $emit('editPost', {
        id: $props.post.id,
        index: $props.index,
        title: $props.post.title
      })
      break;
    case 'delete':
      removePost($props.post.id)
      break;
    case 'pin':
      pinPost($props.post.id)
      break;
  }
}

// NOTE: Remove by [Auth]
async function removePost(id: string) {
  await axios.delete(`/dashboard/manage-posts/${id}`)
  $emit('removePost', $props.index)
}

// NOTE: Pin/Unpin By [admin/Mod]
async function pinPost(id: string) {
  const res = await axios.put(`/dashboard/manage-posts/${id}`, {type: 'pin'})
  $emit('updatedPost', {index: $props.index, data: res.data})
}
</script>
