<template>
  <div class="col-sm-10">
    <h2>All Cob Logs</h2>

    <!-- Search Bar -->
    <div class="row">
      <div class="search-wrapper panel-heading col mb-2">
        <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
      </div>
      <div class="col mt-2">
        Showing
        <b>{{ filteredCobLogs.length }}</b> Results
      </div>
    </div>

    <!-- Pagination -->
    <div class="row">
      <div class="col-sm-6">
        <Pagination
          :items="filteredCobLogs"
          :currentPage="currentPage"
          :pageSize="pageSize"
          v-on:pageUpdate="updatePage"
        ></Pagination>
      </div>
    </div>

    <!-- List of CoB Logs -->
    <div v-if="coblogs.length">
      <div class="card card-body mb-3 border-primary" v-bind:key="coblog.id" v-for="coblog in resultQuery">
        <div class="row">
          <div class="col-sm-11">
            <div class="row">
              <div class="col-sm-12">
                <p>
                  Description:
                  <strong>{{ coblog.description }}</strong>
                </p>
              </div>
              <div class="col-sm-5">
                <p>
                  System:
                  <strong>{{ coblog.system.machine }} | {{ coblog.system.system }}/{{ coblog.system.zone }}</strong>
                </p>
                <p>
                  Runday:
                  <strong>{{ coblog.runday | formatDate }}</strong>
                </p>
                <p>
                  Status:
                  <strong>{{ coblog.status }}</strong>
                </p>
              </div>
              <div class="col-sm-6">
                <p>
                  Release:
                  <strong>{{ coblog.system.release }}</strong>
                </p>
                <p>
                  Next Working Day:
                  <strong>{{ coblog.next_working_day | formatDate }}</strong>
                </p>
                <p>
                  Creator:
                  <strong>{{ coblog.logger.name }}</strong>
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-1 expand d-flex align-items-center justify-content-center">
            <router-link :to="{ name: 'cobLogDetails', params: { id: coblog.id } }">
              <div style="font-size: 2rem">
                <i class="fa fa-chevron-right fa-lg customRightArrow"></i>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import axios from "axios";
import Pagination from "../utility/Pagination.vue";

export default {
  data() {
    return {
      coblogs: [],
      coblog: {
        id: "",
        systemId: "",
        runday: "",
        nextWorkingDay: "",
        start: "",
        end: "",
        status: "",
        runtime: "",
        conclusion: "",
        creator: "",
        createdAt: ""
      },
      searchQuery: "",
      pageSize: 5,
      pagination: {},
      currentPage: 0,
      pageSize: 5,
      cobLogsInPage: [],
      filteredCobLogs: []
    };
  },
  components: {
    Pagination
  },
  created() {
    this.fetchCobLogs();
  },
  methods: {
    fetchCobLogs(page_url) {
      let vm = this;
      page_url = page_url || "/api/coblogs";

      console.log(page_url);
      axios
        .get(page_url)
        .then(res => {
          console.log(res);
          this.coblogs = res.data;
          this.filteredCobLogs = res.data;
          //Update Errors in Page for Pagination
          this.updateCobLogsInPage();
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
    updateCobLogsInPage() {
      let startIndex = this.currentPage * this.pageSize;
      this.cobLogsInPage = this.filteredCobLogs.slice(
        startIndex,
        startIndex + this.pageSize
      );

      // if there are 0 systems, go back a page
      if (this.cobLogsInPage.length === 0 && this.currentPage > 0) {
        this.updatePage(this.currentPage - 1);
      }
    },
    updatePage(pageNumber) {
      this.currentPage = pageNumber;
      this.updateCobLogsInPage();
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
        //Save the result of queries in array filteredCobLogs
        this.filteredCobLogs = this.coblogs.filter(coblog => {
          return (
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.description.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.system.machine.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.system.system.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.system.zone.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.system.release.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.runday.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.next_working_day.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblog.status.toLowerCase().includes(v))
          );
        });

        this.updateCobLogsInPage();

        return this.cobLogsInPage;
      } else {
        this.filteredCobLogs = this.coblogs;
        this.updateCobLogsInPage();
        return this.cobLogsInPage;
      }
    }
  }
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
  opacity: 0.9;
}
.expand {
  border-left: 3px solid indigo;
}
.customRightArrow {
  color: indigo;
}
.customRightArrow:hover {
  color: rgb(205, 183, 221);
}
.customRightArrow:active {
  color: rgb(151, 65, 212);
}
</style>
