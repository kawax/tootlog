<script setup lang="ts">
import {formatDate} from '../support/date';
import {display_name} from '../support/display';
import type {Post, Account} from '../types';

const props = defineProps<{
    post: Post
}>();

const reblog: Post = props.post.reblog;
const account: Account = props.post.reblog.account;
</script>

<template>
    <div class="rounded-lg shadow-sm ring-1 ring-sky-500 mb-2">
        <div class="bg-sky-500 text-white px-4 py-2 rounded-t-lg flex items-center gap-2">
            <img
                class="rounded-full size-6 object-cover"
                :src="post.account.avatar"
                :alt="post.account.display_name"
            />
            <span v-html="display_name(post.account)"></span> reblogged
        </div>

        <div class="p-4">
            <div class="flex gap-3">
                <div class="shrink-0">
                    <a
                        :href="account.url"
                        target="_blank"
                        rel="nofollow noopener"
                        class="no-underline"
                    >
                        <img
                            class="rounded max-w-24"
                            :src="account.avatar"
                            :alt="account.display_name"
                        />
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
                        <small class="text-gray-500 font-normal">
                            @{{ account.acct }}
                        </small>
                    </h4>

                    <button
                        class="bg-yellow-400 text-black px-3 py-1 rounded cursor-pointer text-sm"
                        type="button"
                        v-if="reblog.spoiler_text.length > 0"
                        v-html="reblog.spoiler_text"
                        @click="reblog.spoiler_text = '';"
                    ></button>

                    <div
                        v-if="!reblog.spoiler_text"
                        v-html="reblog.content"
                        class="mb-3"
                    ></div>

                    <div
                        v-if="reblog.media_attachments"
                        v-for="media in reblog.media_attachments"
                        class="mb-2"
                    >
                        <a
                            :href="media.url"
                            target="_blank"
                            ref="nofollow noopener"
                            class="no-underline"
                        >
                            <img
                                :src="media.preview_url"
                                :alt="media.description || 'Media attachment'"
                                class="rounded border border-gray-300"
                            />
                        </a>
                    </div>

                    <div class="text-sm text-gray-600">
                        <a
                            :href="reblog.url"
                            target="_blank"
                            ref="nofollow noopener"
                            class="no-underline hover:underline"
                        >
                            {{ formatDate(reblog.created_at) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
