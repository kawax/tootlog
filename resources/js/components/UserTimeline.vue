<script setup>
import {ref, computed} from 'vue';
import TimelineReblog from './TimelineReblog.vue'
import TimelineStatus from './TimelineStatus.vue'
import Card from './Card.vue'
import TypeSwitch from './TypeSwitch.vue';
import MediaSwitch from './MediaSwitch.vue';
import {useStream} from "../useStream";

const props = defineProps({
    domain: String,
    streaming: String,
    token: String,
});

const active_type = ref('public:local');
const active_media = ref('normal');

const activePosts = computed(() => {
    return posts.value.filter(post => media_check(post))
})

const {posts, errors} = useStream(props.domain, props.token, props.streaming, active_type)

function media_check(post) {
    switch (active_media.value) {
        case 'only':
            return post.media_attachments.length
        case 'except':
            return !post.media_attachments.length
        default:
            return true
    }
}
</script>

<template>
    <div>
        <div class="btn-toolbar mb-2" role="toolbar" aria-label="toolbar">
            <TypeSwitch @changed="(type) => active_type = type"/>

            <MediaSwitch @changed="(media) => active_media = media"/>
        </div>

        <div class="alert alert-danger" v-if="errors.length > 0">
            <p><strong>Whoops!</strong> Something went wrong!</p>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>

        <Card>
            <div v-for="post in activePosts" :key="post.id">
                <TimelineReblog :post="post" v-if="post.reblog"></TimelineReblog>

                <TimelineStatus :post="post" v-else></TimelineStatus>
                <hr/>
            </div>
        </Card>
    </div>
</template>
