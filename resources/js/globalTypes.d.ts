import { FunctionalComponent } from 'vue'
import { PageProps } from '@inertiajs/core'

export type TCTopNavigation = {
  name: string
  icon?: FunctionalComponent
  href: string
  active?: boolean
  component: string
}

export type GTAuth = {
  avatar: string
  created_at: Date
  email: string
  id: string
  name: string
}

export interface TProps {
  auth?: GTAuth
  flash: {
    message: string []
  }
  title: string
  pageTitle: string
  sidebar: boolean
  system_settings: {
    name: string
    config: string
    description: string
  } []
  data?: object
  errors?: object
  logo: {
    lg: string
    sm: string
  }
}

export interface TPagination<T> {
  current_page: number
  data: T []
  total: number
}

export interface TUser {
  id: string
  email: string
  avatar: string
  cover: string
  created_at: string
  name: string
  team_roles?: TRole[]
  roles_teams?: TTeam[]
  roles_teams_head?: TTeam[]
}

export interface TTeam {
  id: string
  name: string
  avatar: string
  cover: string
  display_name: string
  description: string
  created_at: string
  head: TUser[]
  members: TUser[]
}

export interface TRole {
  id: string
  name: string
  display_name: string
  description: string
  created_at: string
  permissions: TPermission []
  users: TUser []
}

export interface TPermission {
  name: string
  display_name: string
  description: string
  id: string
}

export interface TTab {
  display_name: string
  icon: string
}

export interface TTeam {
  id: string
  name: string
  avatar: string
  display_name: string
  description: string
  users: TUser[]
}


export interface TPage extends PageProps {
  // NOTE: Shared
  title: string
  sidebar: boolean
  logo: {
    sm: string
    lg: string
  }
  flash?: {
    error?: string
    success?: string
  }
  auth?: GTAuth

  // NOTE: Independent
  pageTitle: string
}


export interface TFilters {
  search: string
  type: string
  page: number
}
