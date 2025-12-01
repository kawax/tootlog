<script setup lang="ts">
import {ref, watchEffect} from 'vue';
import type {TypeKey} from '../types';
import {HomeIcon, UserGroupIcon, GlobeAltIcon} from '@heroicons/vue/24/outline';

const emit = defineEmits<{
    changed: [type: TypeKey]
}>();

const active_type = ref<TypeKey>('public:local');

const types: { key: TypeKey; icon: typeof HomeIcon; label: string }[] = [
    {key: 'user', icon: HomeIcon, label: 'User'},
    {key: 'public:local', icon: UserGroupIcon, label: 'Local'},
    {key: 'public', icon: GlobeAltIcon, label: 'Federated'},
];

watchEffect(() => emit('changed', active_type.value))
</script>

<template>
    <div class="inline-flex rounded-lg shadow-sm mr-2" role="group">
        <button
            type="button"
            class="px-4 py-2 text-sm font-medium border transition-colors inline-flex items-center gap-1"
            :class="[
                active_type === item.key
                    ? 'bg-gray-700 text-white border-gray-700'
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                index === 0 ? 'rounded-l-lg' : '',
                index === types.length - 1 ? 'rounded-r-lg' : '',
                index !== 0 ? 'border-l-0' : ''
            ]"
            v-for="(item, index) in types"
            :key="item.key"
            @click="active_type = item.key"
        >
            <component :is="item.icon" class="size-5" aria-hidden="true" />
            {{ item.label }}
        </button>
    </div>
</template>
