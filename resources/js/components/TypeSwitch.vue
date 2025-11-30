<script setup lang="ts">
import {ref, watchEffect} from 'vue';
import type {TypeKey, TimelineType} from '../types';

const emit = defineEmits<{
    changed: [type: TypeKey]
}>();

const active_type = ref<TypeKey>('public:local');

const types: TimelineType = {
    user: '<i class="fa fa-home" aria-hidden="true"></i> User',
    'public:local': '<i class="fa fa-users" aria-hidden="true"></i> Local',
    public: '<i class="fa fa-globe" aria-hidden="true"></i> Federated',
};

watchEffect(() => emit('changed', active_type.value))
</script>

<template>
    <div class="inline-flex rounded-lg shadow-sm mr-2" role="group">
        <button
            type="button"
            class="px-4 py-2 text-sm font-medium border transition-colors"
            :class="[
                active_type === type
                    ? 'bg-gray-700 text-white border-gray-700'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                Object.keys(types).indexOf(type) === 0 ? 'rounded-l-lg' : '',
                Object.keys(types).indexOf(type) === Object.keys(types).length - 1 ? 'rounded-r-lg' : '',
                Object.keys(types).indexOf(type) !== 0 ? 'border-l-0' : ''
            ]"
            v-for="(html, type) in types"
            :key="type"
            @click="active_type = type"
            v-html="html"
        ></button>
    </div>
</template>
