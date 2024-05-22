import {useDateFormat} from '@vueuse/core'

export function formatDate(date: string): string {
    return useDateFormat(date, 'YYYY-MM-DD HH:mm:ss').value
}
