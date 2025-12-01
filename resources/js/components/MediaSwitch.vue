<script setup lang="ts">
import {ref, watchEffect} from 'vue';
import type {MediaKey} from '../types';
import {DocumentTextIcon, PhotoIcon, ChatBubbleLeftIcon} from '@heroicons/vue/24/outline';

const emit = defineEmits<{
    changed: [media: MediaKey]
}>();

const active_media = ref<MediaKey>('normal');

const medias: { key: MediaKey; icon: typeof DocumentTextIcon; label: string }[] = [
    {key: 'normal', icon: DocumentTextIcon, label: 'Text and Media'},
    {key: 'only', icon: PhotoIcon, label: 'Media'},
    {key: 'except', icon: ChatBubbleLeftIcon, label: 'Text'},
];

watchEffect(() => emit('changed', active_media.value))
</script>

<template>
    <div class="inline-flex rounded-lg shadow-sm" role="group">
        <button
            type="button"
            class="px-4 py-2 text-sm font-medium border transition-colors inline-flex items-center gap-1"
            :class="[
                active_media === item.key
                    ? 'bg-gray-700 text-white border-gray-700'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                index === 0 ? 'rounded-l-lg' : '',
                index === medias.length - 1 ? 'rounded-r-lg' : '',
                index !== 0 ? 'border-l-0' : ''
            ]"
            v-for="(item, index) in medias"
            :key="item.key"
            @click="active_media = item.key"
        >
            <component :is="item.icon" class="size-5" aria-hidden="true" />
            {{ item.label }}
        </button>
    </div>
</template>
