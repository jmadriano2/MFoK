<template>
  <div class="col-sm-8">
    <h2>All Systems</h2>

    <!-- Search Bar -->
    <div class="row">
      <div class="search-wrapper panel-heading col mb-2">
        <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
      </div>
      <div class="col mt-2">
        Showing
        <b>{{ filteredSystems.length }}</b> Results
      </div>
    </div>

    <!-- Pagination -->
    <div class="row">
      <div class="col-sm-6">
        <Pagination
          :items="filteredSystems"
          :currentPage="currentPage"
          :pageSize="pageSize"
          v-on:pageUpdate="updatePage"
        ></Pagination>
      </div>
      <!-- New System Button -->
      <div class="col-sm-1 offset-sm-5 text-right">
        <NewSystem v-on:refreshPage="refreshPage"></NewSystem>
      </div>
    </div>

    <!-- Systems List -->
    <div v-if="systems.length">
      <div
        class="card card-body mb-3 border-primary"
        v-bind:key="system.id"
        v-for="system in resultQuery"
      >
        <div class="row">
          <div class="col-sm-3">
            <p>
              <strong>Machine: {{system.machine}}</strong>
            </p>
          </div>
          <div class="col-sm-2">
            <p>
              <strong>System: {{system.system}}</strong>
            </p>
          </div>
          <div class="col-sm-2">
            <p>
              <strong>Zone: {{system.zone}}</strong>
            </p>
          </div>
          <div class="col-sm-5">
            <p>
              <strong>Release: {{system.release}}</strong>
            </p>
          </div>
          <div class="col-sm-6">
            <p>
              <strong>Rundate: {{ system.rundate | formatDate }}</strong>
            </p>
          </div>
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <p class="mb-0">
              <strong>Inserted By: {{system.creator.name}}</strong>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from "../utility/Pagination.vue";
import NewSystem from "./NewSystem.vue";
import moment from "moment";
import axios from "axios";

export default {
  data() {
    return {
      searchQuery: "",
      pageSize: 5,
      pagination: {},
      currentPage: 0,
      pageSize: 5,
      systemsInPage: [],
      filteredSystems: [],
      systems: [],
      system: {}
    };
  },
  components: {
    Pagination,
    NewSystem
  },
  mounted() {
    this.fetchSystems();
  },
  methods: {
    fetchSystems(page_url) {
      let vm = this;
      page_url = page_url || "/api/systems";

      console.log(page_url);
      axios
        .get(page_url)
        .then(res => {
          console.log(res);
          this.systems = res.data;
          this.filteredSystems = res.data;
          //Update Errors in Page for Pagination
          this.updateSystemsInPage();
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
    },
    updateSystemsInPage() {
      let startIndex = this.currentPage * this.pageSize;
      this.systemsInPage = this.filteredSystems.slice(
        startIndex,
        startIndex + this.pageSize
      );

      // if there are 0 systems, go back a page
      if (this.systemsInPage.length === 0 && this.currentPage > 0) {
        this.updatePage(this.currentPage - 1);
      }
    },
    updatePage(pageNumber) {
      this.currentPage = pageNumber;
      this.updateSystemsInPage();
    },
    refreshPage() {
      this.fetchSystems();
    }
  },
  filters: {
    formatDate: function(value) {
      if (!value) return "";
      return moment(String(value)).format("dddd, MMMM D, YYYY");
    }
  },
  computed: {
    resultQuery() {
      if (this.searchQuery) {
        //Save the result of queries in array filteredSystems
        this.filteredSystems = this.systems.filter(system => {
          return (
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => system.machine.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => system.system.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => system.zone.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => system.release.toLowerCase().includes(v))
          );
        });

        this.updateSystemsInPage();

        return this.systemsInPage;
      } else {
        this.filteredSystems = this.systems;
        this.updateSystemsInPage();
        return this.systemsInPage;
      }
    }
  },
};
</script>
<style scoped>
h5 {
  color: green;
}
.card {
  background-color: rgba(245, 245, 245, 0.4);
}
.card-header,
.card-footer {
  opacity: 0.7;
}
</style>
