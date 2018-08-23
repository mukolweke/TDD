<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply-view :reply="reply" @deleted="remove(index)"></reply-view>
        </div>

        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
    import ReplyView from './Reply'
    import NewReply from './NewReply';

    export default {
        props: ['data'],

        components: { ReplyView, NewReply },

        data() {
            return{
                items: this.data
            }
        },

        methods: {
            add(reply){
                this.items.push(reply);

                this.$emit('added');

                flash('Reply was added')
            },

            remove(index){
                this.items.splice(index, 1);

                this.$emit('removed');

                flash('Reply was removed')
            }
        }
    }
</script>
