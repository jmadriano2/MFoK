<template>
  <div class="centerForm">
    <div class="card rounded formBorder" style="width: 40rem;">
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
            <form class="mt-3">
              <div class="form-group">
                <div class="input-icon">
                  <input
                    id="username"
                    class="form-control"
                    placeholder="Username"
                    name="username"
                    required
                    autofocus
                  />
                </div>
              </div>
              <div class="form-group">
                <div class="input-icon">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    name="password"
                    required
                  />
                </div>
              </div>
              <button class="btn btn-common log-btn">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
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
</style>
