<template>
    <div>
        <toggle-button
            v-model="check"
            :labels="{
                checked: 'Show',
                unchecked: 'Hide'
            }"
            :color="{
                checked: '#2b90d9',
                unchecked: '#6c757d'
            }"
            width="80"
        ></toggle-button>

        <div class="alert alert-danger" v-if="errors.length > 0">
            <p><strong>Whoops!</strong> Something went wrong!</p>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
import { ToggleButton } from "vue-js-toggle-button";

export default {
    components: {
        ToggleButton
    },
    data() {
        return {
            message: "",
            errors: [],
            check: this.checked
        };
    },
    props: {
        status: String,
        checked: Boolean
    },
    watch: {
        check(val) {
            if (val) {
                this.show();
            } else {
                this.hide();
            }
        }
    },
    methods: {
        show() {
            this.errors = [];

            axios
                .put("/api/status/show/" + this.status)
                .then(res => {
                    this.message = res.data.message;
                })
                .catch(error => {
                    console.log(error);
                    if (typeof error.response.data === "object") {
                        this.errors = _.flatten(_.toArray(error.response.data));
                    } else {
                        this.errors = [
                            "Something went wrong. Please try again."
                        ];
                    }
                });
        },
        hide() {
            this.errors = [];

            axios
                .delete("/api/status/hide/" + this.status)
                .then(res => {
                    this.message = res.data.message;
                })
                .catch(error => {
                    console.log(error);
                    if (typeof error.response.data === "object") {
                        this.errors = _.flatten(_.toArray(error.response.data));
                    } else {
                        this.errors = [
                            "Something went wrong. Please try again."
                        ];
                    }
                });
        }
    }
};
</script>
