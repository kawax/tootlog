<script setup lang="ts">
import {ref, computed} from 'vue';
import TimelineReblog from './TimelineReblog.vue';
import TimelineStatus from './TimelineStatus.vue';
import Card from './Card.vue';
import TypeSwitch from './TypeSwitch.vue';
import MediaSwitch from './MediaSwitch.vue';
import {useStream} from '../useStream';
import {media_check} from '../support/media_check';
import type {MediaKey, TypeKey} from '../types';

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
        <div class="flex gap-2 mb-2" role="toolbar" aria-label="toolbar">
            <TypeSwitch @changed="(type) => active_type = type"/>

            <MediaSwitch @changed="(media) => active_media = media"/>
        </div>

        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4" v-if="errors.length > 0">
            <p class="font-bold mb-2">Whoops! Something went wrong!</p>
            <ul class="list-disc list-inside">
                <li v-for="error in errors" :key="error">{{ error }}</li>
            </ul>
        </div>

        <Card>
            <div v-for="post in active_posts" :key="post.id">
                <TimelineReblog :post="post" v-if="post.reblog"></TimelineReblog>

                <TimelineStatus :post="post" v-else></TimelineStatus>
                <hr class="border-gray-200 dark:border-neutral-500"/>
            </div>
        </Card>
    </div>
</template>
