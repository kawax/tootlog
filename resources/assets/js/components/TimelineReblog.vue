<template>
    <div>
        <span class="label label-info">
            <img class="img-circle toot-icon-small"
                 :src="post.account.avatar">
            {{ post.account.display_name.length > 0 ? post.account.display_name : post.account.username }} reblogged
        </span>

        <div class="media">
            <div class="media-left">
                <a :href="post.reblog.account.url" target="_blank" rel="nofollow noopener">
                    <img class="media-object img-rounded toot-icon"
                         :src="post.reblog.account.avatar">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a :href="post.reblog.account.url" target="_blank" rel="nofollow noopener">
                        {{ post.reblog.account.display_name ? post.reblog.account.display_name : post.reblog.account.username }}
                    </a>
                    <small class="text-muted">
                        @{{ post.reblog.account.acct }}
                    </small>
                </h4>


                <button class="btn btn-warning btn-sm"
                        type="button"
                        v-if="post.reblog.spoiler_text.length != 0"
                        v-html="post.reblog.spoiler_text"
                        @click="post.reblog.spoiler_text = ''">
                </button>

                <div v-if="!post.reblog.spoiler_text" v-html="post.reblog.content">
                </div>

                <div v-if="post.reblog.media_attachments" v-for="media in post.reblog.media_attachments">
                    <a :href="media.url" target="_blank" ref="nofollow noopener">
                        <img :src="media.preview_url" class="img-responsive img-thumbnail">
                    </a>
                </div>

                <div>{{ formatDate(post.reblog.created_at) }}</div>
            </div>
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
