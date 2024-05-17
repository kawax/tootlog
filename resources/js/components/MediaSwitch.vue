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
    <div class="btn-group" role="group">
        <button
            type="button"
            class="btn btn-secondary"
            v-for="(html, media) in medias"
            :class="{ active: active_media === media }"
            @click="active_media = media"
            v-html="html"
        ></button>
    </div>
</template>
