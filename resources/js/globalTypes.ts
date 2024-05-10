import { FunctionalComponent } from 'vue'

export type TCTopNavigation = {
  name: string
  icon?: FunctionalComponent
  href: string
  active?: boolean
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
  roles_teams?: TTeams[]
}

export interface TTeams {
  name: string
  display_name: string
  description: string
  created_at: string
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
  icon?: FunctionalComponent
}

export interface TTeam {
  id: string
  name: string
  display_name: string
  description: string
  users: TUser[]
}
