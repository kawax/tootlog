<script setup lang="ts">
import {formatDate} from '../date'
import {emoji} from '../emoji'
import {display_name} from '../display'
import type {Post, Account} from '../types';

const props = defineProps<{
    post: Post
}>()

const reblog: Post = props.post.reblog
const account: Account = props.post.reblog.account
</script>

<template>
    <div>
        <span class="badge bg-info ms-1">
            <img
                class="rounded-circle toot-icon-small"
                :src="post.account.avatar"
            />
            <span v-html="display_name(post.account)"></span> reblogged
        </span>

        <div class="d-flex m-1 p-1">
            <div class="flex-shrink-0">
                <a
                    :href="account.url"
                    target="_blank"
                    rel="nofollow noopener"
                    class="text-decoration-none"
                >
                    <img
                        class="rounded toot-icon"
                        :src="account.avatar"
                    />
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
                    <small class="text-muted">
                        @{{ account.acct }}
                    </small>
                </h4>

                <button
                    class="btn btn-warning btn-sm"
                    type="button"
                    v-if="reblog.spoiler_text.length > 0"
                    v-html="emoji(reblog.spoiler_text)"
                    @click="reblog.spoiler_text = '';"
                ></button>

                <div
                    v-if="!reblog.spoiler_text"
                    v-html="emoji(reblog.content)"
                ></div>

                <div
                    v-if="reblog.media_attachments"
                    v-for="media in reblog.media_attachments"
                >
                    <a
                        :href="media.url"
                        target="_blank"
                        ref="nofollow noopener"
                        class="text-decoration-none"
                    >
                        <img
                            :src="media.preview_url"
                            class="img-responsive img-thumbnail"
                        />
                    </a>
                </div>

                <div>
                    <a
                        :href="reblog.url"
                        target="_blank"
                        ref="nofollow noopener"
                        class="text-decoration-none"
                    >
                        {{ formatDate(reblog.created_at) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
