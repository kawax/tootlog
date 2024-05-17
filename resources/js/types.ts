export type Post = {
    id: string,
    account: Account,
    content: string,
    spoiler_text: string,
    media_attachments: MediaAttachment[],
    url: string,
    created_at: string,
    reblog?: Post,
}

export type Account = {
    url: string,
    avatar: string,
    acct: string,
    display_name: string,
    username: string,
}

export type MediaAttachment = {
    url: string,
    preview_url: string,
}

export type StreamEvent = {
    event: string,
    payload: any,
}

export type MediaKey = 'normal' | 'only' | 'except';
export type TimelineMedia = Record<MediaKey, string>;

export type TypeKey = 'user' | 'public:local' | 'public';
export type TimelineType = Record<TypeKey, string>;
