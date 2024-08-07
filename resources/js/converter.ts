import moment from 'moment'

export const removeURLParameter = (url: string, parameter: string) => {
  let urlparts = url.split('?');
  if (urlparts.length >= 2) {
    let prefix = encodeURIComponent(parameter) + '=';
    let pars = urlparts[1].split(/[&;]/g);

    for (let i = pars.length; i-- > 0;) {
      if (pars[i].lastIndexOf(prefix, 0) !== -1)
        pars.splice(i, 1);
    }

    return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
  }
  return url;
}

// LINK: https://stackoverflow.com/questions/1497481/javascript-password-generator
export const passwordGenerator = (prefix = '', length = 8) => {
  const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
  let retVal = ""
  for (let i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n));
  }
  return retVal;
}

export const dateTimeFormatted = (dateTime: Date | string) => {
  if(moment().format('YYYYMMDD') === moment(dateTime).format('YYYYMMDD')) {
    return moment(dateTime).format('hh:mm A')
  }
  return moment(dateTime).format('MM/DD/YYYY hh:mm A')
}

export const contentFormatter = (content: string, value: number) => {
  if(value < 1)
    return `No ${content}`
  if(value > 1)
    return `${value} ${content}s`
  return `${value} ${content}`
}

export const defaultRouterState = (only?: string[]) => {
  if(only)
    return {
      preserveScroll: true,
      preserveState: true,
      only: only
    }

  return {
    preserveScroll: true,
    preserveState: true,
  }
}

export const isVideo = (link: string) => {
  const links = link.split('.').pop()

  if(links)
    if(links == 'mp4')
      return true

  return false
}

export const taskIdSplitter = (value: number, mode: 'date_time' | 'incremental') => {
  if(mode === 'date_time')
    return value.toString().substring(0, 6)

  return value.toString().substring(6, 9)
}

export const upperCaseFirstChar = (value: string) => {
  if(value)
    return value.charAt(0).toUpperCase() + value.slice(1)

  return 'N/A'
}

export const errorAlert = (link = '/*', error: Error) => {
  alert(`Error occured on ${link} \n\n Error: ${error}`)
}
