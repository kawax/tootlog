<template>
    <div class="media">
        <div class="media-left">
            <a :href="post.account.url" target="_blank" rel="nofollow noopener">
                <img class="media-object img-rounded toot-icon"
                     :src="post.account.avatar">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <a :href="post.account.url" target="_blank" rel="nofollow noopener">
                    {{ post.account.display_name ? post.account.display_name : post.account.username }}
                </a>
                <small class="text-muted">
                    @{{ post.account.acct }}
                </small>
            </h4>


            <button class="btn btn-warning btn-sm"
                    type="button"
                    v-if="post.spoiler_text.length != 0"
                    v-html="post.spoiler_text"
                    @click="post.spoiler_text = ''">
            </button>

            <div v-if="!post.spoiler_text" v-html="post.content">
            </div>

            <div v-if="post.media_attachments" v-for="media in post.media_attachments">
                <a :href="media.url" target="_blank" ref="nofollow noopener">
                    <img :src="media.preview_url" class="img-responsive img-thumbnail">
                </a>
            </div>

            <div>{{ formatDate(post.created_at) }}</div>
        </div>
    </div>
</template>

<script>
    import format from 'date-fns/format'
    import parse from 'date-fns/parse'

    export default {
        props: [
            'post',
        ],
        methods: {
            formatDate(date) {
                return format(parse(date), 'YYYY-MM-DD HH:mm:ss')
            }
        }
    }
</script>
