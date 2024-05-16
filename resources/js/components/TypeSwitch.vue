<script setup lang="ts">
import {ref, watchEffect} from 'vue';
import {TypeKey, TimelineType} from '../types';

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
    <div class="btn-group pe-1" role="group">
        <button
            type="button"
            class="btn btn-secondary"
            v-for="(html, type) in types"
            :class="{ active: active_type === type }"
            @click="active_type = type"
            v-html="html"
        ></button>
    </div>
</template>
