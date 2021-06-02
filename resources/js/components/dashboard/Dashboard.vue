<template>
  <div>
    <h1>Welcome to Dashboard, {{user.username}}!</h1>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      user: ""
    };
  },
  mounted() {
    axios
      .get("/api/user")
      .then(res => {
        this.user = res.data;
        this.$emit("showNavs", true);
        console.log("ggezgetrekt in " + this.user);
      })
      .catch(function(error) {
        if (error.response) {
          // The request was made and the server responded with a status code
          // that falls out of the range of 2xx
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        }
      });
    console.log("ggezgetrekt blah " + this.user.id);
  },
  methods: {
    logout() {
      axios.post("/api/logout").then(() => {
        this.$router.push({ name: "login" });
      });
    }
  }
};
</script>
