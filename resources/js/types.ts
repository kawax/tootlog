export interface Post {
    account: Account,
    content: string,
    spoiler_text: string,
    media_attachments: Array<Media>,
    url: string,
    created_at: Date,
    reblog?: Post,
}

export interface Account {
    url: string,
    avatar: string,
    acct: string,
    display_name: string,
    username: string,
}

export interface Media {
    url: string,
    preview_url: string,
}
