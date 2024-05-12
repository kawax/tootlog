import type {Post} from './types';

export function media_check(post: Post, active: string) {
    switch (active) {
        case 'only':
            return post.media_attachments.length
        case 'except':
            return !post.media_attachments.length
        default:
            return true
    }
}
