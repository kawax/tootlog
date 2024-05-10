import {format, parseISO} from 'date-fns';

export default function formatDate(date: string): string {
    return format(parseISO(date), 'yyyy-MM-dd HH:mm:ss')
}
