<template>
  <div class="col-md-11">
    <h2>All CoB Errors</h2>

    <!-- Search Bar -->
    <div class="row">
      <div class="search-wrapper panel-heading col mb-2">
        <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
      </div>
      <div class="col mt-2">
        Showing
        <b>{{ filteredErrors.length }}</b> Results
      </div>
    </div>

    <!-- Pagination -->
    <div class="row">
      <div class="col-sm-8">
        <Pagination
          :items="filteredErrors"
          :currentPage="currentPage"
          :pageSize="pageSize"
          v-on:pageUpdate="updatePage"
        ></Pagination>
      </div>
      <!-- New Error Button -->
      <div class="col-sm-1 offset-sm-3 text-right">
        <NewErrorResolution v-on:refreshPage="refreshPage"></NewErrorResolution>
      </div>
    </div>

    <!-- Errors List -->
    <div v-if="errors.length">
      <div
        class="card card-body mb-3 border-primary"
        v-bind:key="error.id"
        v-for="error in resultQuery"
      >
        <div class="row">
          <div
            v-if="isCobDetails"
            class="col-sm-1 r-border d-flex align-items-center justify-content-center"
          >
            <div style="font-size: 3rem" @click="addCoblogError(error.id)">
              <i class="fa fa-angle-double-left customLeftArrow"></i>
            </div>
          </div>
          <div v-bind:class="[isCobDetails ? CDClass : notCDClass]">
            <div class="row justify-content-between">
              <h6 class="ml-3">
                Component:
                <strong>{{ error.component }}</strong> &nbsp;&nbsp;&nbsp; Seq.:
                <strong>{{ error.sequence }}</strong>
              </h6>
              <UpdateErrorResolution
                v-on:refreshPage="refreshPage"
                class="mr-3"
                :selfReported="selfReported(error.resolver.id)"
                :error_id="error.id"
              ></UpdateErrorResolution>
            </div>
            <hr />
            <h6 class="ml-2">Problem:</h6>
            <div v-html="error.problem" class="mb-3 ml-4"></div>
            <h6 class="ml-2">Resolution:</h6>
            <div v-html="error.resolution" class="ml-4"></div>
            <hr />
            <h6>Resolved By: {{ error.resolver.name }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from "../utility/Pagination.vue";
import NewErrorResolution from "./NewError.vue";
import UpdateErrorResolution from "./UpdateError.vue";
import axios from "axios";

export default {
  data() {
    return {
      searchQuery: "",
      errors: [],
      user: {},
      logError: {
        log_id: "",
        error_id: ""
      },
      error_id: "",
      pageSize: 5,
      pagination: {},
      currentPage: 0,
      pageSize: 5,
      errorsInPage: [],
      filteredErrors: [],
      isCobDetails: false,
      CDClass: "col-sm-11",
      notCDClass: "col-sm-12",
      notFillRow: "col-sm-10",
      fillRow: "col-sm-12",
      page_url: ""
    };
  },
  props: ["logDetailsId", "updateAllErrors"],
  components: {
    Pagination,
    NewErrorResolution,
    UpdateErrorResolution
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

    if (window.location.pathname.substring(1, 7) === "coblog") {
      this.isCobDetails = true;
    }

    this.fetchAllErrors();
  },
  methods: {
    fetchAllErrors() {
      let vm = this;
      if (this.isCobDetails) {
        console.log("logDetailsId: " + this.$props.logDetailsId);
        this.page_url = "/api/errors/unselected/" + this.logDetailsId;
      } else {
        this.page_url = "/api/errors";
      }

      console.log("urmum 1 " + this.page_url);
      axios
        .get(this.page_url)
        .then(res => {
          this.errors = res.data;
          this.filteredErrors = res.data;
          //Update Errors in Page for Pagination
          this.updateErrorsInPage();
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
    updateErrorsInPage() {
      let startIndex = this.currentPage * this.pageSize;
      this.errorsInPage = this.filteredErrors.slice(
        startIndex,
        startIndex + this.pageSize
      );

      // if there are 0 errors, go back a page
      if (this.errorsInPage.length === 0 && this.currentPage > 0) {
        this.updatePage(this.currentPage - 1);
      }
    },
    updatePage(pageNumber) {
      this.currentPage = pageNumber;
      this.updateErrorsInPage();
    },
    addCoblogError(errorId) {
      let page_url = window.location.origin + "/api/coblogError";
      this.logError.log_id = this.logDetailsId;
      this.logError.error_id = errorId;

      axios
        .post(page_url, this.logError)
        .then(res => {
          this.$emit("addLogError");
          this.fetchAllErrors();
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
    selfReported(resolver) {
        if(this.user.id === resolver) return true;
        return false;
    },
    refreshPage() {
      this.fetchAllErrors();
    }
  },
  computed: {
    resultQuery() {
      if (this.searchQuery) {
        //Save the result of queries in array filteredErrors
        this.filteredErrors = this.errors.filter(error => {
          return (
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => error.component.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => error.sequence.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => error.problem.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => error.resolution.toLowerCase().includes(v))
          );
        });

        this.updateErrorsInPage();

        return this.errorsInPage;
      } else {
        this.filteredErrors = this.errors;
        this.updateErrorsInPage();
        return this.errorsInPage;
      }
    },
  },
  watch: {
    logDetailsId: function() {
      this.fetchAllErrors();
    },
    updateAllErrors: function() {
      this.fetchAllErrors();
    }
  }
};
</script>

<style scoped>
i {
  cursor: pointer;
}
strong {
  color: green;
}
.r-border {
  border-right: 3px solid indigo;
}
.customLeftArrow {
  color: rgb(187, 125, 231);
}
.customLeftArrow:hover {
  color: rgb(205, 183, 221);
}
.customLeftArrow:active {
  color: rgb(132, 43, 196);
}
.card {
  background-color: rgba(245, 245, 245, 0.938);
}
.card-header,
.card-footer {
  opacity: 0.9;
}
</style>
