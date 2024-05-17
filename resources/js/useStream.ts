import {ref, watchEffect, toValue, Ref} from 'vue';
import type {Post, StreamEvent, TimelineType, TypeKey} from './types';

export function useStream(domain: string, streaming: string, token: string, type: Ref<TypeKey>) {
    const api_version = '/api/v1';
    const max = 50;
    const posts = ref<Post[]>([]);
    const errors = ref<string[]>([]);
    let ws: WebSocket = null;

    const timelines: TimelineType = {
        user: 'home',
        'public:local': 'public?local=true',
        public: 'public',
    };

    watchEffect((): void => {
        stream_close();
        start();
    });

    function start(): void {
        const options: RequestInit = {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }

        fetch(timelines_url(), options)
            .then(res => res.json())
            .then(function (json) {
                posts.value = json;
                stream_open();
            })
            .catch(function (error) {
                console.error(error);
                errors.value.push(error);
            })
    }

    function stream_open(): void {
        ws = new WebSocket(streaming_url())

        ws.onmessage = (ev: MessageEvent<any>): void => {
            console.debug('Got Data from Stream ' + toValue(type))
            let event: StreamEvent = JSON.parse(ev.data)
            event.payload = JSON.parse(event.payload)
            stream_event(event)
        }

        ws.onopen = (): void => {
            console.debug('WebSocket Open ' + domain + ' ' + toValue(type))
        }

        ws.onclose = (): void => {
            console.debug('WebSocket Close ' + domain + ' ' + toValue(type))
        }
    }

    function stream_event(event: StreamEvent): void {
        switch (event.event) {
            case 'update':
                //console.log(event.payload)
                posts.value.unshift(event.payload);
                posts.value.splice(max);
                break;
            default:
                console.debug(event);
        }
    }

    function stream_close(): void {
        if (ws !== null) {
            ws.close()
            posts.value = []
        }
    }

    function timelines_url(): string {
        return domain + api_version + '/timelines/' + timelines[toValue(type)] + '?limit=20'
    }

    function streaming_url(): string {
        return streaming + api_version + '/streaming?access_token=' + token + '&stream=' + toValue(type)
    }

    return {
        posts,
        errors
    }
}
