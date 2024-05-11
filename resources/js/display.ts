import {emoji} from './emoji.js';
import {Account} from './types';

export function display_name(account: Account): string {
    return account.display_name
        ? emoji(account.display_name)
        : account.username
}
