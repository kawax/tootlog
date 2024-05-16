import {ref, watchEffect, toValue} from 'vue';
import type {Post, StreamEvent} from './types';

export function useStream(domain: string, streaming: string, token: string, type: any) {
    const api_version = '/api/v1';
    const max = 50;
    const posts = ref<Post[]>([]);
    const errors = ref<string[]>([]);
    let ws: WebSocket = null;

    const timelines: Object = {
        user: 'home',
        'public:local': 'public?local=true',
        public: 'public',
    };

    watchEffect((): void => {
        start()
    });

    function start(): void {
        steam_close()

        const url: string = endpoint() + '/timelines/' + timelines[toValue(type)] + '?limit=20';

        const options: RequestInit = {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }

        fetch(url, options)
            .then(res => res.json())
            .then(function (json) {
                posts.value = json;
                stream();
            })
            .catch(function (error) {
                console.error(error);
                errors.value.push(error);
            })
    }

    function stream(): void {
        steam_open((event: StreamEvent): void => {
            switch (event.event) {
                case 'update':
                    //console.log(event.payload)
                    posts.value.unshift(event.payload);
                    posts.value.splice(max);
                    break;
                default:
                    console.debug(event);
            }
        })
    }

    function steam_open(onData: (event: StreamEvent) => void): void {
        const url: string = streaming_url() + '/streaming?access_token=' + token + '&stream=' + toValue(type);

        ws = new WebSocket(url)

        ws.onmessage = (ev: MessageEvent<any>): void => {
            console.debug('Got Data from Stream ' + toValue(type))
            let event: StreamEvent = JSON.parse(ev.data)
            event.payload = JSON.parse(event.payload)
            onData(event)
        }

        ws.onopen = () => {
            console.debug('WebSocket Open ' + domain + ' ' + toValue(type))
        }

        ws.onclose = (ev: CloseEvent): void => {
            console.debug('WebSocket Close ' + domain + ' ' + toValue(type))
        }
    }

    function steam_close(): void {
        if (ws !== null) {
            ws.close()
            posts.value = []
        }
    }

    function endpoint(): string {
        return domain + api_version
    }

    function streaming_url(): string {
        return streaming + api_version
    }

    return {
        posts,
        errors
    }
}
