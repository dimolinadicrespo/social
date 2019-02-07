<template>
    <div class="card mb-3 border-0 shadow">
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-2">
                <img class="rounded mr-3" width="40px" src="https://i0.wp.com/aprendible.com/images/default-avatar.jpg?ssl=1" alt="">
                <div>
                    <h5 class="mb-1" v-text="status.user_name"></h5>
                    <div class="small text-muted" v-text="status.ago"></div>
                </div>
            </div>
            <p class="card-text" v-text="status.body"></p>

        </div>
        <div class="card-footer p-2 d-flex justify-content-between align-items-center">
            <like-btn
                dusk="status-like-btn"
                :model="status"
                :url="`statuses/${status.id}/likes`">
            </like-btn>
            <small dusk="status-likes-count" class="text-primary">
                <i class="far fa-thumbs-up mr-1"></i>
                {{ status.count_likes }}
            </small>
        </div>

        <div class="card-footer">
            <div v-for="comment in comments" class="mb-2">
                <div class="d-flex">
                    <img class="rounded mr-2 shadow-sm" :src="comment.user_avatar" width="32px" height="32px" :alt="comment.user_name">
                    <div class="flex-grow-1">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-2 text-secondary">
                                <a href="#"><strong>{{ comment.user_name}} </strong></a>
                                {{ comment.body}}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <like-btn
                                    class="comment-like-btn"
                                    dusk="comment-like-btn"
                                    :model="comment"
                                    :url="`comments/${comment.id}/likes`">
                            </like-btn>
                            <small class="badge badge-primary py-1 px-2"
                                    dusk="comment-like-count">
                                <div>
                                    <i class="far fa-thumbs-up mr-1 text-white"></i>
                                    {{ comment.count_likes }}
                                </div>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="commentStatus" v-if="isAuthenticated">
                <div class="d-flex justify-content-start align-items-start">
                    <img class="rounded float-left mr-2 shadow-sm" src="https://i0.wp.com/aprendible.com/images/default-avatar.jpg?ssl=1" width="34px" :alt="user.name">
                    <div class="input-group">
                        <textarea v-model="newComment" class="form-control border-0" name="comment-area" rows="1" ></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" dusk="comment-btn">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    import LikeBtn from './LikeBtn';
    import LikeCounter from './LikeCounter'

    export default {
        components : { LikeBtn,LikeCounter },
        props: {
            status: {
                type: Object,
                required: true
            }
        },
        data(){
            return {
                newComment: '',
                comments: this.status.comments
            }
        },
        methods:{
            commentStatus(){
                axios.post(`statuses/${this.status.id}/comments`,{ body:this.newComment })
                    .then(res =>{
                        this.newComment = "";
                        this.comments.push(res.data.data);
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            }
        }
    }
</script>

<style scoped>

</style>