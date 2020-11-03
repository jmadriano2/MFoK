<template>
  <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
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
        console.log('i was here');
      this.$emit('toggleSidebar');
    },
  },
};
</script>