import { quantityWords } from '@/Utils/QuantityWords'

export function backendDateFormat(date) {
  const year = date.toLocaleString('default', { year: 'numeric' })
  const month = date.toLocaleString('default', { months: '2-digit' })
  const day = date.toLocaleString('default', { day: '2-digit' })

  return day + '-' + month + '-' + year
}

export function frontendDateFormat(date) {
  const year = date.toLocaleString('default', { year: 'numeric' })
  const month = date.toLocaleString('default', { month: '2-digit' })
  const day = date.toLocaleString('default', { day: '2-digit' })

  return day + '.' + month + '.' + year
}

export function frontendDateTimeFormat(date) {
  const year = date.toLocaleString('default', { year: 'numeric' })
  const month = date.toLocaleString('default', { month: '2-digit' })
  const day = date.toLocaleString('default', { day: '2-digit' })
  const hour = date.toLocaleString('default', { hour: '2-digit' })
  const minute = date.toLocaleString('default', { minute: '2-digit' })

  return day + '.' + month + '.' + year + ' ' + hour + ':' + (minute < 10 ? '0' : '') + minute
}

export function getLengthFromSeconds(seconds) {
  if (seconds >= 60 * 60 * 24 * 30) {
    const number = Math.floor(seconds / 60 / 60 / 24 / 30)

    return number + ' ' + quantityWords({
      one: 'месяц',
      two: 'месяца',
      five: 'месяцев',
    }, number)
  } else if (seconds >= 60 * 60 * 24 * 7) {
    const number = Math.floor(seconds / 60 / 60 / 24 / 7)

    return number + ' ' + quantityWords({
      one: 'неделя',
      two: 'недели',
      five: 'недель',
    }, number)
  } else if (seconds >= 60 * 60 * 24) {
    const number = Math.floor(seconds / 60 / 60 / 24)

    return number + ' ' + quantityWords({
      one: 'день',
      two: 'дня',
      five: 'дней',
    }, number)
  } else if (seconds >= 60 * 60) {
    const number = Math.floor(seconds / 60 / 60)

    return number + ' ' + quantityWords({
      one: 'час',
      two: 'часа',
      five: 'часов',
    }, number)
  } else {
    const number = Math.floor(seconds / 60)

    return number + ' ' + quantityWords({
      one: 'минута',
      two: 'минуты',
      five: 'минут',
    }, number)
  }
}
