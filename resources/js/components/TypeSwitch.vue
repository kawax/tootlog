<script setup>
import {ref} from "vue";

const emit = defineEmits(['typeChanged'])

const active_type = ref('public:local');

const types = {
    user: '<i class="fa fa-home" aria-hidden="true"></i> User',
    'public:local': '<i class="fa fa-users" aria-hidden="true"></i> Local',
    public: '<i class="fa fa-globe" aria-hidden="true"></i> Federated',
};

function typeChanged(type) {
    active_type.value = type;
    emit('typeChanged', type);
}
</script>

<template>
    <div class="btn-group pe-1" role="group">
        <button
            type="button"
            class="btn btn-secondary"
            v-for="(text, type) in types"
            :class="{ active: active_type === type }"
            @click="typeChanged(type)"
            v-html="text"
        ></button>
    </div>
</template>
