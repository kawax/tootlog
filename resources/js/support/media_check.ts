import type {Post} from '../types';

export function media_check(post: Post, active: string): boolean {
    switch (active) {
        case 'only':
            return post.media_attachments.length > 0
        case 'except':
            return !post.media_attachments.length
        default:
            return true
    }
}
