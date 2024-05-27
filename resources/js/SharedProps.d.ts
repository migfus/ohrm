import { TUser } from "./globalTypes"

interface SharedProps{
    auth: TUser
    [key: string]: any
}

export default SharedProps
