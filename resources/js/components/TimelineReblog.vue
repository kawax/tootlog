<template>
    <div>
        <span class="badge bg-info ms-1">
            <img
                class="rounded-circle toot-icon-small"
                :src="post.account.avatar"
            />
            <span v-html="display_name()"></span> reblogged
        </span>

        <div class="d-flex m-1 p-1">
            <div class="flex-shrink-0">
                <a
                    :href="post.reblog.account.url"
                    target="_blank"
                    rel="nofollow noopener"
                >
                    <img
                        class="rounded toot-icon"
                        :src="post.reblog.account.avatar"
                    />
                </a>
            </div>
            <div class="flex-grow-1 ms-3">
                <h4>
                    <a
                        :href="post.reblog.account.url"
                        v-html="reblog_display_name()"
                        target="_blank"
                        rel="nofollow noopener"
                    >
                    </a>
                    <small class="text-muted">
                        @{{ post.reblog.account.acct }}
                    </small>
                </h4>

                <button
                    class="btn btn-warning btn-sm"
                    type="button"
                    v-if="post.reblog.spoiler_text.length > 0"
                    v-html="emoji(post.reblog.spoiler_text)"
                    @click="post.reblog.spoiler_text = '';"
                ></button>

                <div
                    v-if="!post.reblog.spoiler_text"
                    v-html="emoji(post.reblog.content)"
                ></div>

                <div
                    v-if="post.reblog.media_attachments"
                    v-for="media in post.reblog.media_attachments"
                >
                    <a
                        :href="media.url"
                        target="_blank"
                        ref="nofollow noopener"
                    >
                        <img
                            :src="media.preview_url"
                            class="img-responsive img-thumbnail"
                        />
                    </a>
                </div>

                <div>
                    <a
                        :href="post.reblog.url"
                        target="_blank"
                        ref="nofollow noopener"
                    >
                        {{ formatDate(post.reblog.created_at) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { format, parseISO } from 'date-fns'
import emoji from '../emoji'

export default {
    props: {
        post: Object,
    },
    methods: {
        display_name () {
            return this.post.account.display_name.length > 0
                ? this.emoji(this.post.account.display_name)
                : this.post.account.username
        },
        reblog_display_name () {
            return this.post.reblog.account.display_name
                ? this.emoji(this.post.reblog.account.display_name)
                : this.post.reblog.account.username
        },
        emoji (input) {
            return emoji.toImage(input)
        },
        formatDate (date) {
            return format(parseISO(date), 'yyyy-MM-dd HH:mm:ss')
        },
    },
}
</script>
