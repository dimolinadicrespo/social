<template>
    <div @click="redirectIfGuest">
        <status-list-item
                v-for="status in statuses"
                :status="status"
                :key="status.id">
        </status-list-item>
    </div>
</template>

<script>
    import StatusListItem from './StatusListItem';

    export default {
        components:{ StatusListItem },

        data(){
            return {
               statuses : [], comments: [],
            }
        },
        mounted(){
            axios.get('statuses')
                .then(response => {
                    this.statuses = response.data.data;
                })
                .catch(errors => {

                });
            EventBus.$on('status-created', status => {
               this.statuses.unshift(status);
            });
        },

    }
</script>

<style scoped>

</style>