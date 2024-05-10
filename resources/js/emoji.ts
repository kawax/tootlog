import twemoji from '@twemoji/api';

export default function emoji(input: string | HTMLElement): string {
    return <string>twemoji.parse(input);
}
