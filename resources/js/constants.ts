import { TCTopNavigation } from "./globalTypes"
import { CalendarIcon, HomeIcon, Squares2X2Icon } from "@heroicons/vue/24/outline"

export const CTopNavigation: TCTopNavigation[] = [
  {
    name: 'Home',
    icon: HomeIcon,
    href: '/',
  },
  {
    name: 'Groups',
    icon: Squares2X2Icon,
    href: '/group',
  },
  {
    name: 'Calendar',
    icon: CalendarIcon,
    href: '/calendar',
  },
]
