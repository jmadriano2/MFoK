<template>
  <nav class="navbar navbar-expand-sm navbar-dark mb-2 custom">
    <div class="container-fluid">
      <button type="button" class="btn btn-info" v-on:click="toggleSidebar()">
        <i class="fa fa-align-left"></i>
        <span>Toggle Sidebar</span>
      </button>
      <a href="#" class="navbar-brand"
        >Midas CoB Logger
        <img class="navbarLogo" src="/images/MFoK_logo_v2.png"
      /></a>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    toggleSidebar() {
      this.$emit("toggleSidebar");
    },
  },
};
</script>

<style scoped>
.custom {
  background-color: #d2cbeb;
}

a {
  font-weight: bold;
  color: black !important;
}
.navbarLogo {
  height: 4vh;
  border-radius: 25%;
}
</style>
