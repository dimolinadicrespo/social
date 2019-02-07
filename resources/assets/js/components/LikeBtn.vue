<template>
    <button
        @click="toggle()"
        :class="getClassesBtn">
        <i :class="getClassesIcon"></i>
        {{ getText }}
    </button>
</template>

<script>
    export default {
        props: {
            model:{
                type: Object,
                required: true
            },
            url:{
                required: true,
            }
        },
        methods:{
            toggle(){
                let method = (this.model.is_liked) ? 'delete' :'post';
                axios[method](this.url)
                    .then(res => {
                        this.model.is_liked = ! this.model.is_liked;
                        if (this.model.is_liked)
                            this.model.count_likes++;
                        else
                            this.model.count_likes--;
                    });
            },
            like(){
                axios.post(this.url)
                    .then(res => {
                        this.model.is_liked = true;
                        this.model.count_likes++
                    });
            },
            unlike(){
                axios.delete(this.url)
                    .then( res => {
                        this.model.is_liked = false;
                        this.model.count_likes--
                    });
            }
        },
        computed: {
            getText: function(){
               return this.model.is_liked ? 'Te gusta' : 'Me gusta';
            },
            getClassesBtn: function() {
                return [
                    (this.model.is_liked) ? "small font-weight-bold" : "",
                    "btn" , "btn-link"
                ]
            },
            getClassesIcon: function() {
                return [
                    (this.model.is_liked) ? "fas" : "far",
                    "fa-thumbs-up", "mr-1"
                ]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .comment-like-btn{
        font-size: 0.9em;
        padding-left: 0;
        i{
            display: none;
        }
    }
</style>