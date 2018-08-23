<template>
    <div :id="'reply-'+id" class="card" style="margin-bottom:30px;padding:15px;">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + reply.owner.name"
                       v-text="reply.owner.name">
                    </a> said <span v-text="ago"></span>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>

        <div class="card-section" style="margin-top:10px;margin-bottom:10px;">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea class="form-control"
                                  id="body"
                                  v-model="body"
                                  rows="5"></textarea>
                        <!--<wysiwyg v-model="body"></wysiwyg>-->
                    </div>

                    <button class="btn btn-xs btn-primary">Update</button>
                    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"></div>
        </div>

        <div class="card-footer level" v-if="canUpdate">
            <div>
                <button class="btn btn-xs mr-1" @click="editing = true" v-if="! editing">Edit</button>
                <button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
            </div>

            <!--<button class="btn btn-xs btn-default ml-a" @click="markBestReply" v-if="authorize('owns', reply.thread)">-->
                <!--Best Reply?-->
            <!--</button>-->
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: {Favorite},

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow() + '...';
            },

            signedIn() {
                return window.App.signedIn;
            },

            canUpdate() {
                return this.authorize(user => this.reply.user_id == user.id)
            }
        },

        created() {
            this.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                this.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
