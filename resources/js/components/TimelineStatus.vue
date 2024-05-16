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
    <div class="d-flex p-1 m-1">
        <div class="flex-shrink-0">
            <a :href="account.url" target="_blank" rel="nofollow noopener" class="text-decoration-none">
                <img class="rounded toot-icon" :src="account.avatar"/>
            </a>
        </div>

        <div class="flex-grow-1 ms-3">
            <h4>
                <a
                    :href="account.url"
                    v-html="display_name(account)"
                    target="_blank"
                    rel="nofollow noopener"
                    class="text-decoration-none"
                >
                </a>
                <small class="text-muted"> @{{ account.acct }} </small>
            </h4>

            <button
                class="btn btn-warning btn-sm"
                type="button"
                v-if="post.spoiler_text.length > 0"
                v-html="emoji(post.spoiler_text)"
                @click="post.spoiler_text = '';"
            ></button>

            <div v-if="!post.spoiler_text" v-html="emoji(post.content)"></div>

            <div
                v-if="post.media_attachments"
                v-for="media in post.media_attachments"
            >
                <a :href="media.url" target="_blank" ref="nofollow noopener" class="text-decoration-none">
                    <img
                        :src="media.preview_url"
                        class="img-responsive img-thumbnail"
                    />
                </a>
            </div>

            <div>
                <a :href="post.url" target="_blank" ref="nofollow noopener" class="text-decoration-none">
                    {{ formatDate(post.created_at) }}
                </a>
            </div>
        </div>
    </div>
</template>
