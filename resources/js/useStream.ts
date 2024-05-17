import {onMounted, ref, Ref, toValue, watch} from 'vue';
import {useFetch, useWebSocket} from '@vueuse/core';
import type {Post, StreamEvent, TimelineType, TypeKey} from './types';

export function useStream(domain: string, streaming: string, token: string, type: Ref<TypeKey>) {
    const api_version = '/api/v1';
    const max = 50;
    const posts = ref<Post[]>([]);
    const errors = ref<string[]>([]);
    let ws_close = null;

    const timelines: TimelineType = {
        user: 'home',
        'public:local': 'public?local=true',
        public: 'public',
    };

    onMounted(() => start());

    watch(type, (): void => {
        stream_close();
        start();
    });

    function start(): void {
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

        onFetchError((error) => {
            console.error(error);
            errors.value.push(error);
        });
    }

    function stream_open(): void {
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
        if (ws_close !== null) {
            ws_close();
        }
        posts.value = [];
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
