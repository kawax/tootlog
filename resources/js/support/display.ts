import type {Account} from '../types';

export function display_name(account: Account): string {
    return account.display_name
        ? account.display_name
        : account.username
}
