<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li v-show="prevUrl" class="page-item">
            <a class="page-link" rel="previsous" @click.prevent="page--">
                <span aria-hidden="true">&laquo;Previous</span>
            </a>
        </li>
        <li v-show="nxtUrl" class="page-item">
            <a class="page-link" rel="next" @click.prevent="page++">
                <span aria-hidden="true">Next&laquo;</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {

        props: ['dataSet'],

        data() {
            return {
                page: 1,
                nxtUrl: false,
                prevUrl: false,
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.nxtUrl = this.dataSet.next_page_url;
                this.prevUrl = this.dataSet.prev_page_url;
            },

            page(){
                this.broadcast().updateUrl();
            }
        },

        methods: {
            shouldPaginate() {
                return !!this.prevUrl || !!this.nxtUrl;
            },

            broadcast(){
                return this.$emit('changed', this.page);
            },

            updateUrl(){
                history.pushState(null, null, '?page' + this.page)
            }
        }
    }
</script>

<style scoped>

</style>