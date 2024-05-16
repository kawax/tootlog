import twemoji from '@twemoji/api';

export function emoji(input: string | HTMLElement): string {
    return <string>twemoji.parse(input);
}
