import { Page, PageProps } from '@inertiajs/core'
import type { GTAuth } from './globalTypes'

interface SharedProps extends PageProps {
  auth?: GTAuth
  errors: Object
  title: string
  flash?: Object
}

export default SharedProps

declare module '@inertiajs/vue3' {
  export function usePage(): Page<SharedProps>
}
