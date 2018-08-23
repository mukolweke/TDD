<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
            <textarea name="body"
                      id="body"
                      placeholder="Have something to say..."
                      rows="5"
                      v-model="body"
                      class="form-control" required></textarea>
            </div>

            <button type="submit" @click="addReply" class="btn btn-default">Post</button>
        </div>
        <p class="text-center" v-else>Please<a href="/login">&nbsp;sign in&nbsp;</a> to participate in this
            discussion</p>
    </div>
</template>

<script>
    // import 'jquery.caret';
    // import 'at.js';

    export default {
        data() {
            return {
                body: '',
                completed: false
            };
        },

        mounted() {
            // $('#body').atwho({
            //     at: "@",
            //     delay: 750,
            //     callbacks: {
            //         remoteFilter: function (query, callback) {
            //             $.getJSON("/api/users", {name: query}, function (usernames) {
            //                 callback(usernames)
            //             });
            //         }
            //     }
            // });
        },

        computed:{
            signedIn(){
                return window.App.signedIn;
            }
        },

        methods: {

            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;

                        flash('Your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
