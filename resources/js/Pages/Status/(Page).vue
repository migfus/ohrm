<script setup lang="ts">
import { useTitle } from '@vueuse/core'
import {
  BriefcaseIcon,
  DocumentDuplicateIcon,
  ArrowPathIcon,
} from '@heroicons/vue/24/outline'

useTitle('Status | OHRM')

const menu = [
  {
    category: 'RSP - Recruitment, Selection & Placement',
    color: 'bg-brand-800/5',
    children: [
      {
        name: 'Application Concern',
        color: 'bg-rose-700 text-rose-50',
        image: 'https://images.unsplash.com/photo-1635350736475-c8cef4b21906?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: BriefcaseIcon,
      },
      {
        name: 'Job Order Contract',
        color: 'bg-cyan-700 text-cyan-50',
        image: 'https://images.unsplash.com/photo-1564846824194-346b7871b855?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: DocumentDuplicateIcon,
      },
      {
        name: 'Renewal/PDS',
        color: 'bg-amber-700 text-amber-50',
        image: 'https://images.unsplash.com/photo-1562654501-a0ccc0fc3fb1?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: ArrowPathIcon,
      },
    ],
  },
]

const people = [
  {
    name: 129,
    email: 'leslie.alexander@example.com',
    role: 'Request for Landbank',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    dateTime: '12/12/2023 12:12 AM'
  },
  {
    name: '127',
    email: 'leslie.alexander@example.com',
    role: 'Request for Landbank',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    dateTime: '12/12/2023 12:12 AM'
  },
  {
    name: '127',
    email: 'leslie.alexander@example.com',
    role: 'Request for Landbank',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    dateTime: '12/12/2023 12:12 AM'
  },
  {
    name: '127',
    email: 'leslie.alexander@example.com',
    role: 'Request for Landbank',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    dateTime: '12/12/2023 12:12 AM'
  },
  {
    name: '127',
    email: 'leslie.alexander@example.com',
    role: 'Request for Landbank',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    dateTime: '12/12/2023 12:12 AM'
  },
  {
    name: '127',
    email: 'leslie.alexander@example.com',
    role: 'Request for Landbank',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    dateTime: '12/12/2023 12:12 AM'
  },
  {
    name: '127',
    email: 'leslie.alexander@example.com',
    role: 'Request for Landbank',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    dateTime: '12/12/2023 12:12 AM',
    serving: true,
  },
]
</script>

<template>
  <div class="aspect-video w-screen">
    <div class="grid grid-cols-4 max-w-7xl mx-auto gap-4">
      <div class="my-4 col-span-3 grid grid-cols-2 gap-4">

        <div class="col-span-2">
          <section class="overflow-hidden bg-gray-50 py-12 md:py-20 lg:py-20 rounded-xl shadow">
            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
              <svg class="absolute top-full right-full translate-x-1/3 -translate-y-1/4 transform lg:translate-x-1/2 xl:-translate-y-1/2" width="404" height="404" fill="none" viewBox="0 0 404 404" role="img" aria-labelledby="svg-workcation">
                <title id="svg-workcation">Workcation</title>
                <defs>
                  <pattern id="ad119f34-7694-4c31-947f-5c9d249b21f3" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                  </pattern>
                </defs>
                <rect width="404" height="404" fill="url(#ad119f34-7694-4c31-947f-5c9d249b21f3)" />
              </svg>

              <div class="relative">
                <img class="mx-auto h-8" src="https://tailwindui.com/img/logos/workcation-logo-indigo-600-mark-gray-800-and-indigo-600-text.svg" alt="Workcation" />
                <blockquote class="mt-10">
                  <div class="mx-auto max-w-3xl text-center text-2xl font-medium leading-9 text-gray-900">
                    <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita voluptas culpa sapiente alias molestiae. Numquam corrupti in laborum sed rerum et corporis.&rdquo;</p>
                  </div>
                  <footer class="mt-8">
                    <div class="md:flex md:items-center md:justify-center">
                      <div class="md:flex-shrink-0">
                        <img class="mx-auto h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                      </div>
                      <div class="mt-3 text-center md:mt-0 md:ml-4 md:flex md:items-center">
                        <div class="text-base font-medium text-gray-900">Judith Black</div>

                        <svg class="mx-1 hidden h-5 w-5 text-brand-600 md:block" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M11 0h3L9 20H6l5-20z" />
                        </svg>

                        <div class="text-base font-medium text-gray-500">CEO, Workcation</div>
                      </div>
                    </div>
                  </footer>
                </blockquote>
              </div>
            </div>
          </section>
        </div>


        <!-- NOTE: YOUTUBE EMBED -->
        <div class="aspect-video bg-brand-50">
          <iframe class="aspect-video w-full rounded-xl" src="https://www.youtube.com/embed/Wv0TYJBRSP0?si=rxyc0aU77YbKvHQT&amp;controls=0&amp;autoplay=1&amp;loop=1&amp;mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <!-- NOTE: Boost Productivity Card -->
        <div class="bg-brand-50 rounded-xl">
          <div class="relative isolate overflow-hidden bg-gray-900 px-6 py-7 text-center shadow rounded-xl">
            <h2 class="mx-auto max-w-2xl text-4xl font-bold tracking-tight text-white">Boost your productivity.</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">Incididunt sint fugiat pariatur cupidatat consectetur sit cillum </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
              <a href="#" class="rounded-md bg-white px-3.5 py-1.5 text-base font-semibold leading-7 text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Get started</a>
              <a href="#" class="text-base font-semibold leading-7 text-white">Learn more <span aria-hidden="true">→</span></a>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" class="absolute top-1/2 left-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2" aria-hidden="true">
              <circle cx="512" cy="512" r="512" fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)" fill-opacity="0.7" />
              <defs>
                <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(512 512) rotate(90) scale(512)">
                  <stop stop-color="#7775D6" />
                  <stop offset="1" stop-color="#E935C1" stop-opacity="0" />
                </radialGradient>
              </defs>
            </svg>
          </div>
        </div>

      </div>

      <!-- NOTE: QUEUING -->
      <div class="flex flex-col bg-brand-50 p-4 sm:rounded-xl shadow my-4">
        <h1 class="text-md font-semibold mb-2">Queuing</h1>
          <div class="flex gap-1 justify-between">
            <div class="relative overflow-hidden bg-yellow-200 border mb-2 py-4 px-2 rounded-xl">
              ###
            </div>
            <div class="relative overflow-hidden bg-white border mb-2 py-4 px-2 rounded-xl">
              #123
            </div>
            <div class="relative overflow-hidden bg-white border mb-2 py-4 px-2 rounded-xl">
              #123
            </div>
            <div class="relative overflow-hidden bg-white border mb-2 py-4 px-2 rounded-xl">
              #123
            </div>
            <div class="relative overflow-hidden bg-white border mb-2 py-4 px-2 rounded-xl">
              #123
            </div>
          </div>

          <div
            v-for="person in people"
            :key="person.email"
            class="relative overflow-hidden bg-white border mb-2 p-4 rounded-xl"
          >

            <div class="min-w-0 flex-1">
              <a href="#" class="focus:outline-none">
                <div class="flex justify-between">
                  <p :class="['text-gray-900', 'text-md font-medium ']">
                  #{{ person.name }}
                  </p>
                  <p v-if="!person.serving" :class="['text-gray-500', 'truncate text-xs mt-1']">
                    <!-- <ClockIcon class="h-4 w-4 inline mb-1"/> -->
                    {{ person.dateTime }}
                  </p>
                </div>

                <p :class="['text-gray-500', 'truncate text-md font-semibold']">
                  <!-- <PencilSquareIcon class="h-4 w-4 inline mb-1"/> -->
                  {{ person.role }}
                </p>

              </a>
            </div>

            <div v-if="person.serving" class="absolute right-0 top-0">
              <div
                class="absolute transform rotate-45 bg-green-600 text-center text-white text-xs py-1 right-[-65px] top-[8px] w-[170px]">
                Serving
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</template>

