import twemoji from "@twemoji/api";

export default function emoji(input: string | HTMLElement): string | HTMLElement {
    return twemoji.parse(input);
}
