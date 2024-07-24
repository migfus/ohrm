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
        <PostDropown :isPinned="$props.post.is_pinned" :postId="post.id" :index :groupId/>
      </div>
    </div>

    <!-- NOTE: POSTCARD CONTENTS -->
    <div ref="sentenceLines" class="m-1 bg-white px-4 py-2 rounded-lg mx-4 shadow font-medium text-md">

      <div v-if="minimize_content" v-html="$props.post.title" class="line-clamp-4" ></div>
      <div v-else v-html="$props.post.title"></div>

      <MultimediaPreview
        v-if="$props.post.post_type.name == 'Multimedia'"
        :user="$props.post.user"
        :title="$props.post.title"
        :createdAt="$props.post.created_at"
        :contents="$props.post.post_contents"
        :counts="$props.post.post_contents_count ?? 0"
      />

      <DocumentsPreview
        v-if="$props.post.post_type.name == 'Documents'"
        :name="$props.post.user.name"
        :title="$props.post.title"
        :createdAt="$props.post.created_at"
        :contents="$props.post.post_contents"
        :counts="$props.post.post_contents_count"
      />

      <div v-else-if="$props.post.post_type.name == 'Documents'">[Post Type Documents]</div>
    </div>

    <button v-if="height > 95" class="mx-4 text-sm" @click="minimize_content = !minimize_content">{{ minimize_content ? 'Show More...' : 'Show Less...'}}</button>

    <!-- NOTE: POSTCARD FOOTER -->
    <div class="flex justify-between mx-4 py-2 text-sm gap-4">
      <span class="">
        <ReactDropdown
          :reactionUsers="post.reaction_users"
          :postId="post.id"
          :authReactionId="post.auth_reaction?.reaction_id"
        />
      </span>
      <span class="cursor-pointer">{{ contentFormatter('Comment', post.comments_count) }}</span>
    </div>

    <!-- NOTE: COMMENTS SECTION -->
    <CommentSection
      :comments="post.comments"
      :comments_count="post.comments_count"
      :post_id="$props.post.id"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useElementSize } from '@vueuse/core'
import { Post } from '@/globalTypes'
import { contentFormatter, dateTimeFormatted } from '@/converter'

import { MapPinIcon } from '@heroicons/vue/24/solid'

import PostDropown from '@/components/dropdowns/PostDropown.vue'
import MultimediaPreview from './MultimediaPreview.vue'
import DocumentsPreview from './DocumentsPreview.vue'
import ReactDropdown from '@/components/dropdowns/ReactDropdown.vue'
import CommentSection from './comments/CommentSection.vue'

const $props = defineProps<{
  groupId: string
  post: Post
  index: number
}>()

const minimize_content = ref(true)
const sentence_lines = ref(null)
const { height } = useElementSize(sentence_lines)
</script>
