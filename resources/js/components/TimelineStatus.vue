<template>
    <div class="d-flex p-1 m-1">
        <div class="flex-shrink-0">
            <a :href="post.account.url" target="_blank" rel="nofollow noopener" class="text-decoration-none">
                <img class="rounded toot-icon" :src="post.account.avatar"/>
            </a>
        </div>

        <div class="flex-grow-1 ms-3">
            <h4>
                <a
                    :href="post.account.url"
                    v-html="display_name()"
                    target="_blank"
                    rel="nofollow noopener"
                    class="text-decoration-none"
                >
                </a>
                <small class="text-muted"> @{{ post.account.acct }} </small>
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

<script>
import { format, parseISO } from 'date-fns'
import emoji from '../emoji'

export default {
    props: {
        post: Object,
    },
    methods: {
        display_name () {
            return this.post.account.display_name
                ? this.emoji(this.post.account.display_name)
                : this.post.account.username
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
