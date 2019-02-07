<template>
    <div class="card border-0 bg-light">
        <form @submit.prevent="submit" v-if="isAuthenticated" >
            <div class="card-body ">
                <textarea v-model="body"
                          class="form-control border-0 bg-light"
                          name="body"
                          :placeholder="'¿En qué estás penando'+user.name+'?'"></textarea>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="create-status">
                    <i class="fa fa-paper-plane mr-1"></i>
                    Publicar
                </button>
            </div>
        </form>
        <div v-else class="card-body">
            <a class="btn btn-primary btn-block" href="/login">Login</a>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                body: '',
            }
        },
        methods: {
            submit(){
                axios.post('statuses',{body:this.body})

                    .then(response =>{
                        EventBus.$emit('status-created',response.data.data);
                        this.body = "";
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