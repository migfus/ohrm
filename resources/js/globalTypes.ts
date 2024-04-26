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

