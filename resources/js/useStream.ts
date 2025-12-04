import {onMounted, ref, Ref, toValue, watch} from 'vue';
import {useFetch, useWebSocket} from '@vueuse/core';
import type {Post, StreamEvent, TypeKey} from './types';

export function useStream(domain: string, streaming: string, token: string, type: Ref<TypeKey>) {
    const API_VERSION = '/api/v1';
    const POST_LIMIT = 50;
    const posts = ref<Post[]>([]);
    const errors = ref<string[]>([]);
    let ws_close = null;

    const timelines = {
        user: 'home',
        'public:local': 'public?local=true',
        public: 'public',
    };

    onMounted(() => start());

    watch(type, () => {
        stream_close();
        start();
    });

    function start() {
        const {onFetchResponse, onFetchError} = useFetch(timelines_url(), {
            async beforeFetch({options}) {
                options.headers = {
                    ...options.headers,
                    Authorization: `Bearer ${token}`,
                }

                return {
                    options,
                }
            },
        });

        onFetchResponse(async (response: Response) => {
            posts.value = await response.json();
            stream_open();
        });

        onFetchError(error => {
            console.error(error);
            errors.value.push(error);
        });
    }

    function stream_open() {
        const {close} = useWebSocket(streaming_url(), {
            autoClose: false,
            onMessage: (ws: WebSocket, ev: MessageEvent) => {
                let event: StreamEvent = JSON.parse(ev.data)
                event.payload = JSON.parse(event.payload)
                stream_event(event)
            },
            onConnected(ws) {
                console.debug('WebSocket Open ' + domain + ' ' + toValue(type))
            },
            onDisconnected(ws, event) {
                console.debug('WebSocket Close ' + domain)
            },
            onError(ws, event) {
                console.debug('WebSocket Error ' + domain + ' ' + toValue(type))
            },
        });

        ws_close = close;
    }

    function stream_event(event: StreamEvent) {
        switch (event.event) {
            case 'update':
                //console.log(event.payload)
                posts.value.unshift(event.payload);
                posts.value.splice(POST_LIMIT);
                break;
            default:
                console.debug(event);
        }
    }

    function stream_close() {
        if (ws_close !== null) {
            ws_close();
        }
        posts.value = [];
    }

    function timelines_url(): string {
        return domain + API_VERSION + '/timelines/' + timelines[toValue(type)] + '?limit=20'
    }

    function streaming_url(): string {
        return streaming + API_VERSION + '/streaming?access_token=' + token + '&stream=' + toValue(type)
    }

    return {
        posts,
        errors
    }
}
