import {ref, watchEffect, toValue} from 'vue';

export function useStream(domain: string, token: string, streaming: string, type: any) {
    const api_version = '/api/v1';
    const max = 50;
    const posts = ref([]);
    const errors = ref([]);
    let ws: WebSocket = null;

    const timelines = {
        user: 'home',
        'public:local': 'public?local=true',
        public: 'public',
    };

    watchEffect(() => {
        start()
    })

    function start() {
        steam_close()

        fetch(endpoint() + '/timelines/' + timelines[toValue(type)] + '?limit=20', {
            headers: {
                Authorization: 'Bearer ' + token
            }
        })
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

    function stream() {
        steam_open(data => {
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

    function steam_open(onData: any) {
        ws = new WebSocket(streaming_url() + '/streaming?access_token=' + token + '&stream=' + toValue(type))

        ws.onmessage = event => {
            console.log('Got Data from Stream ' + toValue(type))
            let ev = JSON.parse(event.data)
            ev.payload = JSON.parse(ev.payload)
            onData(ev)
        }

        ws.onclose = event => {
            console.log('WebSocket Close ' + toValue(type))
        }
    }

    function steam_close() {
        if (ws !== null) {
            ws.close()
            posts.value = []
        }
    }

    function endpoint() {
        return domain + api_version
    }

    function streaming_url() {
        return streaming + api_version
    }

    return {
        posts,
        errors
    }
}
