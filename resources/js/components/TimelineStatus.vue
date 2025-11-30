<script setup lang="ts">
import {formatDate} from '../support/date';
import {emoji} from '../support/emoji';
import {display_name} from '../support/display';
import type {Post, Account} from '../types';

const props = defineProps<{
    post: Post
}>();

const account: Account = props.post.account;
</script>

<template>
    <div class="flex gap-3 p-2 m-1">
        <div class="shrink-0">
            <a :href="account.url" target="_blank" rel="nofollow noopener" class="no-underline">
                <img class="rounded max-w-24" :src="account.avatar" :alt="account.display_name"/>
            </a>
        </div>

        <div class="flex-1">
            <h4 class="text-lg font-semibold mb-1">
                <a
                    :href="account.url"
                    v-html="display_name(account)"
                    target="_blank"
                    rel="nofollow noopener"
                    class="no-underline"
                >
                </a>
                <small class="text-gray-500 font-normal"> @{{ account.acct }} </small>
            </h4>

            <button
                class="bg-yellow-400 text-black px-3 py-1 rounded cursor-pointer text-sm"
                type="button"
                v-if="post.spoiler_text.length > 0"
                v-html="emoji(post.spoiler_text)"
                @click="post.spoiler_text = '';"
            ></button>

            <div v-if="!post.spoiler_text" v-html="emoji(post.content)" class="mb-3"></div>

            <div
                v-if="post.media_attachments"
                v-for="media in post.media_attachments"
                class="mb-2"
            >
                <a :href="media.url" target="_blank" ref="nofollow noopener" class="no-underline">
                    <img
                        :src="media.preview_url"
                        :alt="media.description || 'Media attachment'"
                        class="rounded border border-gray-300"
                    />
                </a>
            </div>

            <div class="text-sm text-gray-600">
                <a :href="post.url" target="_blank" ref="nofollow noopener" class="no-underline hover:underline">
                    {{ formatDate(post.created_at) }}
                </a>
            </div>
        </div>
    </div>
</template>
