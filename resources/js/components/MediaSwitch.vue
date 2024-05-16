<script setup lang="ts">
import {ref, watchEffect} from 'vue';
import {TimelineMedia} from '../types';

const emit = defineEmits<{
    changed: [media: string]
}>();

const active_media = ref<string>('normal');

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
            v-for="(text, media) in medias"
            :class="{ active: active_media === media }"
            @click="active_media = media"
            v-html="text"
        ></button>
    </div>
</template>
