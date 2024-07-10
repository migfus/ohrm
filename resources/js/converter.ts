import moment from 'moment'

export const removeURLParameter = (url: string, parameter: string) => {
  //prefer to use l.search if you have a location/link object
  var urlparts = url.split('?');
  if (urlparts.length >= 2) {

      var prefix = encodeURIComponent(parameter) + '=';
      var pars = urlparts[1].split(/[&;]/g);

      //reverse iteration as may be destructive
      for (var i = pars.length; i-- > 0;) {
          //idiom for string.startsWith
          if (pars[i].lastIndexOf(prefix, 0) !== -1) {
              pars.splice(i, 1);
          }
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


export const dateTimeFormatted = (dateTime: Date) => {
  if(moment().format('YYYYMMDD') === moment(dateTime).format('YYYYMMDD')) {
    return moment(dateTime).format('hh:mm A')
  }
  return moment(dateTime).format('YYYY-MM-DD hh:mm A')
}

export const contentFormatter = (content: string, value: number) => {
  if(value > 1) {
    return `${value} ${content}s`
  }
  return `${value} ${content}`
}
