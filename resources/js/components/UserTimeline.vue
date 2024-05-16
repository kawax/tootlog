<script setup lang="ts">
import {ref, computed} from 'vue';
import TimelineReblog from './TimelineReblog.vue';
import TimelineStatus from './TimelineStatus.vue';
import Card from './Card.vue';
import TypeSwitch from './TypeSwitch.vue';
import MediaSwitch from './MediaSwitch.vue';
import {useStream} from '../useStream';
import {media_check} from '../support/media_check';
import {MediaKey, TypeKey} from "../types";

const props = defineProps<{
    domain: string,
    streaming: string,
    token: string
}>();

const active_type = ref<TypeKey>('public:local');
const active_media = ref<MediaKey>('normal');

const {posts, errors} = useStream(props.domain, props.streaming, props.token, active_type)

const active_posts = computed(() => {
    return posts.value.filter(post => media_check(post, active_media.value))
})
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
            <div v-for="post in active_posts" :key="post.id">
                <TimelineReblog :post="post" v-if="post.reblog"></TimelineReblog>

                <TimelineStatus :post="post" v-else></TimelineStatus>
                <hr/>
            </div>
        </Card>
    </div>
</template>
