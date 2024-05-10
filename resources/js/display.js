import emoji from "./emoji.js";

export default function display_name(account) {
    return account.display_name
        ? emoji(account.display_name)
        : account.username
}
