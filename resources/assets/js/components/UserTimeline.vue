<template>
    <div>

        <div class="btn-group" style="margin-bottom: 10px;" role="group">
            <button type="button" class="btn btn-default"
                    v-for="(text, type) in types"
                    :class="{active : active_type === type}"
                    @click="get(type)"
                    v-html="text"></button>
        </div>

        <div class="alert alert-danger" v-if="errors.length > 0">
            <p><strong>Whoops!</strong> Something went wrong!</p>
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>

        <tt-card>
            <div v-for="post in posts">

                <tt-timeline-reblog :post="post" v-if="post.reblog"></tt-timeline-reblog>

                <tt-timeline-status :post="post" v-else></tt-timeline-status>

                <hr>
            </div>
        </tt-card>

    </div>
</template>

<script>
    import format from 'date-fns/format'
    import parse from 'date-fns/parse'

    export default {
        data() {
            return {
                api_version: '/api/v1',
                ws: null,
                types: {
                    'user': '<i class="fa fa-home" aria-hidden="true"></i> User',
                    'public:local': '<i class="fa fa-users" aria-hidden="true"></i> Local',
                    'public': '<i class="fa fa-globe" aria-hidden="true"></i> Federated'
                },
                timelines: {
                    'user': 'home',
                    'public:local': 'public?local=true',
                    'public': 'public'
                },
                titles: {
                    mention: 'mentioned you',
                    reblog: 'boosted your status',
                    favourite: 'favourited your status',
                    follow: 'followed you',
                },
                active_type: 'public:local',
                posts: [],
                count: 0,
                max: 50,
                errors: [],
            }
        },
        computed: {
            endpoint() {
                return this.domain + this.api_version
            },
            streaming_url() {
                return this.streaming + this.api_version
            }
        },
        props: [
            'domain',
            'streaming',
            'token',
        ],
        mounted() {
            this.get(this.active_type)
        },
        methods: {
            get(type = 'public:local') {
                this.steam_close()

                this.active_type = type

                const timeline = this.timelines[type]

                axios.get(this.endpoint + '/timelines/' + timeline + '?limit=20', {
                    headers: {'Authorization': 'Bearer ' + this.token}
                }).then(res => {
                    console.log(res)
                    this.posts = res.data

                    this.stream(type)
                }).catch(error => {
                    console.log(error)
                    if (typeof error.response.data === 'object') {
                        this.errors = _.flatten(_.toArray(error.response.data));
                    } else {
                        this.errors = ['Something went wrong. Please try again.'];
                    }
                })
            },
            stream(type = 'public:local') {

                this.steam_open(type, data => {
                    // data is an object containing two entries
                    // event determines which type of data you got
                    // payload is the actual data
                    // event can be notification or update
                    if (data.event === "notification") {
                        // data.payload is a notification
                        console.log(data)

                        let name = _.isEmpty(data.payload.account.display_name) ? data.payload.account.username : data.payload.account.display_name
                        let title = this.notificationTitle(data.payload.type, name)
                        let body = _.isEmpty(data.payload.status.spoiler_text) ? data.payload.status.content : data.payload.status.spoiler_text
                        body = $('<p>').html(body).text()

                        if ("Notification" in window) {
                            if ('Audio' in window) {
                                let sound = new Audio(require('../../sounds/boop2.mp3'))
                                sound.play()
                            }

                            Notification.requestPermission().then(() => {
                                new Notification(title, {
                                    body,
                                    icon: data.payload.account.avatar,
                                    tag: data.payload.id
                                });
                            })

                        }

                    } else if (data.event === "update") {
                        // status update for one of your timelines
//                        console.log(data.payload)

                        this.posts.unshift(data.payload)

                        this.posts.splice(this.max)

                    } else {
                        // probably an error
                    }
                })
            },
            steam_open(streamType, onData) {

                const a = document.createElement('a');
                a.href = this.streaming_url
                a.protocol = a.protocol.replace('http', 'ws');

                this.ws = new WebSocket(a.href + "/streaming?access_token=" + this.token + "&stream=" + streamType);

                this.ws.onmessage = (event) => {
                    console.log("Got Data from Stream " + streamType);
                    event = JSON.parse(event.data);
                    event.payload = JSON.parse(event.payload);
                    onData(event);
                };

                this.ws.onclose = (event) => {
                    console.log("WebSocket Close " + streamType);
                }
            },
            steam_close() {
                if (!_.isNull(this.ws)) {
                    this.ws.close()
                    this.posts = []
                }
            },
            notificationTitle(type, name) {
                return name + ' ' + this.titles[type]
            },
            formatDate(date) {
                return format(parse(date), 'YYYY-MM-DD HH:mm:ss')
            }
        }
    }
</script>
