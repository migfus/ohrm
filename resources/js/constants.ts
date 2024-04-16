import { TCTopNavigation } from "./globalTypes"
import { HomeIcon, RssIcon,  QuestionMarkCircleIcon } from "@heroicons/vue/24/outline"

export const CTopNavigation: TCTopNavigation[] = [
  {
    name: 'Home',
    icon: HomeIcon,
    href: '/',
  },
  {
    name: 'Status',
    icon: RssIcon,
    href: '/status',
  },
  {
    name: 'Contact Us',
    icon: QuestionMarkCircleIcon,
    href: '/contact',
  },
]
