<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>


    </div>
</template>

<script>
    import Reply from './Reply'
    import NewReply from './NewReply';

    export default {
        props: ['data'],

        components: { Reply },



        data() {
            return{
                items: this.data
            }
        },

        methods: {
            remove(index){
                this.items.splice(index, 1);

                this.$emit('removed');

                flash('Reply was removed')
            }
        }
    }
</script>
