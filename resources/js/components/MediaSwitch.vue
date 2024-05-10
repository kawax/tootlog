<script setup>
import {ref} from "vue";

const emit = defineEmits(['mediaChanged'])

const active_media = ref('normal');

const medias = {
    normal: '<i class="fa fa-file-image-o" aria-hidden="true"></i> Media Default',
    only: '<i class="fa fa-picture-o" aria-hidden="true"></i> Only',
    except: '<i class="fa fa-commenting-o" aria-hidden="true"></i> Except',
};

function mediaChanged(media) {
    active_media.value = media;
    emit('mediaChanged', media);
}
</script>

<template>
    <div class="btn-group" role="group">
        <button
            type="button"
            class="btn btn-secondary"
            v-for="(text, media) in medias"
            :class="{ active: active_media === media }"
            @click="mediaChanged(media)"
            v-html="text"
        ></button>
    </div>
</template>
