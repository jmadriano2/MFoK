<template>
  <nav class="navbar navbar-expand-sm navbar-dark mb-2 custom">
    <div class="container-fluid">
      <button
        type="button"
        class="btn btn-info"
        v-on:click="toggleSidebar()"
      >
        <i class="fa fa-align-left"></i>
        <span>Toggle Sidebar</span>
      </button>
      <a href="#" class="navbar-brand">Midas Fountain of Knowledge</a>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    toggleSidebar() {
      this.$emit('toggleSidebar');
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
</style>