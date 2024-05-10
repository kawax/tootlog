import twemoji from "@twemoji/api";

export default function emoji(input) {
    return twemoji.parse(input);
}
