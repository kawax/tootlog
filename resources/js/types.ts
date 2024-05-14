export type Post = {
    id: string,
    account: Account,
    content: string,
    spoiler_text: string,
    media_attachments: Array<Media>,
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

export type Media = {
    url: string,
    preview_url: string,
}

export type StreamEvent = {
    event: string,
    payload: any,
}

export type TimelineMedia = Record<'normal' | 'only' | 'except', string>

export type TimelineType = Record<'user' | 'public:local' | 'public', string>
