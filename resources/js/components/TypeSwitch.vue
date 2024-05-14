<script setup lang="ts">
import {ref} from 'vue';
import {TimelineType} from '../types';

const emit = defineEmits<{
    changed: [type: string]
}>();

const active_type = ref<string>('public:local');

const types: TimelineType = {
    user: '<i class="fa fa-home" aria-hidden="true"></i> User',
    'public:local': '<i class="fa fa-users" aria-hidden="true"></i> Local',
    public: '<i class="fa fa-globe" aria-hidden="true"></i> Federated',
} as const;

function change(type: string): void {
    active_type.value = type;
    emit('changed', type);
}
</script>

<template>
    <div class="btn-group pe-1" role="group">
        <button
            type="button"
            class="btn btn-secondary"
            v-for="(text, type) in types"
            :class="{ active: active_type === type }"
            @click="change(type)"
            v-html="text"
        ></button>
    </div>
</template>
