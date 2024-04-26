<template>
  <li>
    <a :href="$props.data.href" class="block hover:bg-gray-50 bg-white">
      <div class="flex items-center px-4 py-4 sm:px-6">
        <div class="flex min-w-0 flex-1 items-center">
          <div class="flex-shrink-0">
            <img class="h-12 w-12 rounded-full" :src="$props.data.applicant.imageUrl" alt="" />
          </div>
          <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
            <div>
              <p class="truncate text-sm font-semibold text-brand-700">{{ $props.data.applicant.name }}</p>
              <p class="mt-2 flex items-center text-sm text-brand-500 font-semibold">
                <span class="truncate">{{ $props.data.position }}</span>
              </p>
            </div>
            <div class="hidden md:block">
              <div>
                <p class="text-sm text-gray-900">
                  Joined on
                  {{ ' ' }}
                  <time :datetime="$props.data.date">{{ $props.data.dateFull }}</time>
                </p>
                <p class="mt-2 flex items-center text-sm text-gray-500">
                  <CheckCircleIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-brand-400" aria-hidden="true" />
                  {{ $props.data.stage }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div>
          <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </div>
      </div>
    </a>
  </li>
</template>

<script setup lang="ts">
import { CheckCircleIcon, ChevronRightIcon, EnvelopeIcon } from '@heroicons/vue/20/solid'

const $props = defineProps<{
  data: {
    applicant: {
      name: string
      email: string
      imageUrl: string
    }
    date: string
    dateFull: string
    stage: string
    href: string
    position: string
  }
}>()
</script>
