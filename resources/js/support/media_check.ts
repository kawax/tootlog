import type {MediaKey, Post} from '../types';

export function media_check(post: Post, active: MediaKey): boolean {
    switch (active) {
        case 'only':
            return post.media_attachments.length > 0
        case 'except':
            return post.media_attachments.length === 0
        default:
            return true
    }
}
