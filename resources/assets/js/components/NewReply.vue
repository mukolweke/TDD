<template>
    <div>
        <div class="form-group">
            <textarea name="body"
                      id="body"
                      placeholder="Have something to say..."
                      rows="5"
                      v-model="body"
                      class="form-control" required></textarea>
        </div>

        <button type="submit" @click="addReply" class="btn btn-default">

        </button>
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
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function (query, callback) {
                        $.getJSON("/api/users", {name: query}, function (usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
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
