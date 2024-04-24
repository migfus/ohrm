import { TCTopNavigation } from "./globalTypes"
import { HomeIcon, RssIcon, QuestionMarkCircleIcon, TableCellsIcon, Cog6ToothIcon, SquaresPlusIcon } from "@heroicons/vue/24/outline"

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

export const CSidebarNavigation: TCTopNavigation[] = [
  {
    name: 'Dashboard',
    icon: SquaresPlusIcon,
    href: '/dashboard'
  },
  {
    name: 'My Groups',
    icon: TableCellsIcon,
    href: '/my-groups'
  },
  {
    name: 'Account Settings',
    icon: Cog6ToothIcon,
    href: '/account'
  }
]
