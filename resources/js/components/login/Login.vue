<template>
  <div class="centerForm">
    <div class="card rounded formBorder" style="width: 40rem">
      <div class="card-body">
        <div class="formHeader">
          <img src="/images/MFoK_logo_v2.png" class="logo" />
          <h2>
            Midas Fountain
            <br />of Knowledge
          </h2>
        </div>
        <div class="row mt-5">
          <div class="col-sm-8 offset-sm-2">
            <form class="mt-3" id="login" @submit.prevent="login">
              <div class="form-group">
                <div class="input-icon">
                  <i class="fa fa-user"></i>
                  <input
                    id="username"
                    class="form-control"
                    placeholder="Username"
                    v-model="credentials.username"
                    name="username"
                    required
                    autofocus
                  />
                </div>
              </div>
              <div class="form-group">
                <div class="input-icon">
                  <i class="fa fa-key"></i>
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    v-model="credentials.password"
                    name="password"
                    required
                  />
                </div>
              </div>
              <button type="submit" class="btn btn-common log-btn">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      credentials: {
        name: "",
        username: "",
        password: ""
      }
    };
  },
  mounted() {
    console.log("ggezgetrekt ");
    this.$emit("showNavs", false);
    axios
      .get("/api/user")
      .then(res => {
        this.$router.push({ name: "dashboard" })
      })
      .catch(err => {
        console.log(err);
      });
  },
  methods: {
    login() {
      console.log("urmum");

      axios.get("/sanctum/csrf-cookie").then(response => {
        console.log(response);
        this.name = this.username;
        axios.post("/api/login", this.credentials).then(response => {
          console.log(response);
          if(response.data.username != null){
            console.log("wtf man");
            this.$router.push({ name: "dashboard" })
          }
          }).catch(error => {
            this.errors = error.response.data.errors;
            console.log(error);
        });
      });
    }
  }
};
</script>
<style scoped>
.centerForm {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100%;
}
.formHeader {
  display: flex;
  justify-content: center;
  align-items: center;
}
.logo {
  height: 10vh;
}
.btn {
  padding: 12px 30px;
  color: #fff;
  position: relative;
  width: 100%;
  -webkit-transition: all 0.3s linear;
  -moz-transition: all 0.3s linear;
  -ms-transition: all 0.3s linear;
  -o-transition: all 0.3s linear;
  transition: all 0.3s linear;
  border: none;
}
.btn-common:hover,
.btn-common:focus {
  color: #fff;
  background: #cc9cd8;
  box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12), 0 1px 6px 0 rgba(0, 0, 0, 0.12);
}
.btn-search-icon:hover {
  opacity: 0.8;
}
.btn-common {
  background-color: #cc9cd8;
  border: none;
  border-radius: 50px;
  text-transform: uppercase;
  overflow: hidden;
  position: relative;
}
.formBorder {
  border: 3px solid #cc9cd8;
}
.input-icon input {
  padding-left: 40px;
}
.input-icon {
  position: relative;
}
.input-icon i {
  color: #444;
  opacity: 0.6;
  padding-right: 10px;
  margin-top: -3px;
}
.input-icon i {
  font-size: 15px;
  left: 12px;
  line-height: 22px;
  margin-top: -11px;
  position: absolute;
  top: 50%;
}
</style>
