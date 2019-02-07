<template>
    <div class="badge badge-primary badge-pill">
        <i class="far fa-thumbs-up mr-1 text-white"></i>
        <span> {{ countableItem.count_likes}} </span>
    </div>
</template>

<script>
    export default {
        props: {
            countableItem:{
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>