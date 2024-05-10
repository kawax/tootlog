import {format, parseISO} from "date-fns";

export default function formatDate(date) {
    return format(parseISO(date), 'yyyy-MM-dd HH:mm:ss')
}
