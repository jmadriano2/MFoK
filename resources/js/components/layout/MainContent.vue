<template>
  <div class="wrapper">
    <Sidebar v-bind:sidebarActive="sidebarActive"></Sidebar>

    <div id="content">
      <Navbar v-on:toggleSidebar="sidebarToggle"></Navbar>
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <Errors></Errors>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import Errors from "../errors/Errors.vue";

export default {
  data() {
    return {
      sidebarActive: true,
    };
  },
  components: {
    Sidebar,
    Navbar,
    Errors,
  },
  methods: {
    sidebarToggle() {
        console.log('i was here 2');
      this.sidebarActive = !this.sidebarActive;
    },
  },
};
</script>

<style scoped>
.wrapper {
  display: flex;
  width: 100%;
  align-items: stretch !important;
}

#content {
  width: 100%;
}
</style>