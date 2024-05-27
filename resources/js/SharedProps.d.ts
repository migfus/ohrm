import { TUser } from "./globalTypes"

interface SharedProps{
  title: string
  sidebar: boolean
  logo: {
    lg: string
    sm: string
  }
  pageTitle: string
  flash?: {
    error: string
    success: string
  }
  auth?: TUser

  [key: string]: any
}

export default SharedProps
