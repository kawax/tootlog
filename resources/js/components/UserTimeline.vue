<script setup>
import {ref, onMounted, computed} from "vue";
import TimelineReblog from './TimelineReblog.vue'
import TimelineStatus from './TimelineStatus.vue'
import Card from './Card.vue'
import TypeSwitch from "./TypeSwitch.vue";
import MediaSwitch from "./MediaSwitch.vue";

const props = defineProps({
    domain: String,
    streaming: String,
    token: String,
});

const api_version = '/api/v1';
const max = 50;

const active_type = ref('public:local');
const active_media = ref('normal');
const posts = ref([]);
const errors = ref([]);

const timelines = {
    user: 'home',
    'public:local': 'public?local=true',
    public: 'public',
};

let ws = null;

const activePosts = computed(() => {
    return posts.value.filter(post => media_check(post))
})

onMounted(() => get())

function get(type = 'public:local') {
    steam_close()

    active_type.value = type

    axios.get(endpoint() + '/timelines/' + timelines[type] + '?limit=20', {
        headers: {Authorization: 'Bearer ' + props.token},
    }).then(res => {
        //console.log(res.data)
        posts.value = res.data

        stream(type)
    }).catch(error => {
        console.log(error)
        if (typeof error.response.data === 'object') {
            errors.value = _.flatten(_.toArray(error.response.data))
        } else {
            errors.value = [
                'Something went wrong. Please try again.',
            ]
        }
    })
}

function stream(type = 'public:local') {
    steam_open(type, data => {
        // data is an object containing two entries
        // event determines which type of data you got
        // payload is the actual data
        // event can be notification or update
        if (data.event === 'notification') {
            // data.payload is a notification
            console.log(data)
        } else if (data.event === 'update') {
            // status update for one of your timelines
            //console.log(data.payload)

            posts.value.unshift(data.payload)

            posts.value.splice(max)
        } else {
            // probably an error
        }
    })
}

function steam_open(streamType, onData) {
    ws = new WebSocket(
        streaming_url() +
        '/streaming?access_token=' +
        props.token +
        '&stream=' +
        streamType,
    )

    ws.onmessage = event => {
        console.log('Got Data from Stream ' + streamType)
        event = JSON.parse(event.data)
        event.payload = JSON.parse(event.payload)
        onData(event)
    }

    ws.onclose = event => {
        console.log('WebSocket Close ' + streamType)
    }
}

function steam_close() {
    if (!_.isNull(ws)) {
        ws.close()
        posts.value = []
    }
}

function media_check(post) {
    if (active_media.value === 'only') {
        //console.log(post)
        return !_.isEmpty(post.media_attachments)
    } else if (active_media.value === 'except') {
        return _.isEmpty(post.media_attachments)
    }

    return true
}

function endpoint() {
    return props.domain + api_version
}

function streaming_url() {
    return props.streaming + api_version
}
</script>

<template>
    <div>
        <div class="btn-toolbar mb-2" role="toolbar" aria-label="toolbar">
            <TypeSwitch @type-changed="get"/>

            <MediaSwitch @media-changed="(media) => active_media = media"/>
        </div>

        <div class="alert alert-danger" v-if="errors.length > 0">
            <p><strong>Whoops!</strong> Something went wrong!</p>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>

        <Card>
            <div v-for="post in activePosts">
                <TimelineReblog :post="post" v-if="post.reblog"></TimelineReblog>

                <TimelineStatus :post="post" v-else></TimelineStatus>
                <hr/>
            </div>
        </Card>
    </div>
</template>
