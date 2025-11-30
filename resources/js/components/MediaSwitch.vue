<script setup lang="ts">
import {ref, watchEffect} from 'vue';
import type {MediaKey, TimelineMedia} from '../types';

const emit = defineEmits<{
    changed: [media: MediaKey]
}>();

const active_media = ref<MediaKey>('normal');

const medias: TimelineMedia = {
    normal: '<i class="fa fa-file-image-o" aria-hidden="true"></i> Text and Media',
    only: '<i class="fa fa-picture-o" aria-hidden="true"></i> Media',
    except: '<i class="fa fa-commenting-o" aria-hidden="true"></i> Text',
};

watchEffect(() => emit('changed', active_media.value))
</script>

<template>
    <div class="inline-flex rounded-lg shadow-sm" role="group">
        <button
            type="button"
            class="px-4 py-2 text-sm font-medium border transition-colors"
            :class="[
                active_media === media
                    ? 'bg-gray-700 text-white border-gray-700'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                Object.keys(medias).indexOf(media) === 0 ? 'rounded-l-lg' : '',
                Object.keys(medias).indexOf(media) === Object.keys(medias).length - 1 ? 'rounded-r-lg' : '',
                Object.keys(medias).indexOf(media) !== 0 ? 'border-l-0' : ''
            ]"
            v-for="(html, media) in medias"
            :key="media"
            @click="active_media = media"
            v-html="html"
        ></button>
    </div>
</template>
