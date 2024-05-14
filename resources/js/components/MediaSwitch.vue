<script setup lang="ts">
import {ref} from 'vue';

const emit = defineEmits<{
    changed: [media: string]
}>();

const active_media = ref<string>('normal');

const medias: Object = {
    normal: '<i class="fa fa-file-image-o" aria-hidden="true"></i> Media Default',
    only: '<i class="fa fa-picture-o" aria-hidden="true"></i> Only',
    except: '<i class="fa fa-commenting-o" aria-hidden="true"></i> Except',
};

function change(media: string): void {
    active_media.value = media;
    emit('changed', media);
}
</script>

<template>
    <div class="btn-group" role="group">
        <button
            type="button"
            class="btn btn-secondary"
            v-for="(text, media) in medias"
            :class="{ active: active_media === media }"
            @click="change(media)"
            v-html="text"
        ></button>
    </div>
</template>
