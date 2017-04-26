<template>
    <div>
        <button type="button" class="btn btn-danger btn-xs" @click="hide" v-if="!message">
            <i class="fa fa-eye-slash" aria-hidden="true"></i>
            Hide
        </button>

        <div class="alert alert-danger" v-if="errors.length > 0">
            <p><strong>Whoops!</strong> Something went wrong!</p>
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>

        <div v-if="message">
            <tt-status-show :status="status"></tt-status-show>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: '',
                errors: [],
            }
        },
        props: [
            'status',
        ],
        methods: {
            hide() {
                this.errors = [];

                axios.delete('/api/status/hide/' + this.status).then(res => {
                    this.message = res.data.message
                }).catch(error => {
                    console.log(error)
                    if (typeof error.response.data === 'object') {
                        this.errors = _.flatten(_.toArray(error.response.data));
                    } else {
                        this.errors = ['Something went wrong. Please try again.'];
                    }
                })
            },
        }
    }
</script>
