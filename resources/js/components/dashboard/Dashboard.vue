<template>
    <div>
        <h1>Welcome to Dashboard, {{user.username}}!</h1>
    </div>
</template>
<script>
import axios from "axios";

export default {
    data(){
        return{
            user:'',
        }
    },
    mounted(){
        console.log("ggezgetrekt " + this.user);
        axios.get('/api/user').then((res) => {
            this.user = res.data
            this.$emit("showNavs", true);
            console.log("ggezgetrekt in " + this.user);
        }).catch((err) => {
            console.log(err);
        });
    },
    methods: {
        logout() {
            axios.post('/api/logout').then(()=>{
                this.$router.push({ name: "login" })
            })
        }
    }
}
</script>
