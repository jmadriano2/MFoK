<template>
  <div class="wrapper">
    <Sidebar v-bind:sidebarActive="sidebarActive" v-if="authenticated" ></Sidebar>

    <div id="content">
      <Navbar v-on:toggleSidebar="sidebarToggle" v-if="authenticated" ></Navbar>
      <div class="container-fluid">
        <div class="row">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import Errors from "../errors/Errors.vue";
import NewCobLog from "../coblogs/NewCobLog.vue";

export default {
  data() {
    return {
      sidebarActive: true,
      authenticated: false,
    };
  },
  components: {
    Sidebar,
    Navbar,
    Errors,
    NewCobLog,
  },
  methods: {
    sidebarToggle() {
      console.log("i was here 2");
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
