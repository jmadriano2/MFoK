<template>
  <div class="col-sm-12">
    <h2>All CoB Errors</h2>
    <div class="row">
      <div class="search-wrapper panel-heading col mb-2">
        <input
          class="form-control"
          type="text"
          v-model="searchQuery"
          placeholder="Search"
        />
      </div>
      <div class="col mt-2">
        Showing <b>{{ filteredErrors.length }}</b> Results
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <Pagination
          v-bind:errors="filteredErrors"
          v-bind:currentPage="currentPage"
          v-bind:pageSize="pageSize"
          v-on:pageUpdate="updatePage"
        >
        </Pagination>
      </div>
      <div class="col-sm-1 offset-sm-5 text-right">
        <NewError v-on:refreshPage="refreshPage"></NewError>
      </div>
    </div>

    <div v-if="errors.length">
      <div
        class="card card-body mb-2"
        v-bind:key="error.id"
        v-for="error in resultQuery"
      >
        <div class="row">
          <div
            v-if="isCobDetails"
            class="col-sm-1 r-border d-flex align-items-center justify-content-center"
          >
            <div style="font-size: 4rem" @click="addCoblogError(error.id)">
              <i class="fa fa-angle-double-left customLeftArrow"></i>
            </div>
          </div>
          <div v-bind:class="[isCobDetails ? CDClass : notCDClass]">
            <h5>
              Component:
              <strong>{{ error.component }}</strong> &nbsp;&nbsp;&nbsp; Seq.:
              <strong>{{ error.sequence }}</strong>
            </h5>
            <hr />
            <h5>Problem:</h5>
            <p>
              <strong>{{ error.problem }}</strong>
            </p>
            <h5>Resolution:</h5>
            <p>
              <strong>{{ error.resolution }}</strong>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from "../utility/Pagination.vue";
import NewError from "./NewError.vue";

export default {
  data() {
    return {
      searchQuery: "",
      errors: [],
      error: {
        id: "",
        component: "",
        sequence: "",
        problem: "",
        resolution: "",
        og_resolver: "",
        created_at: "",
      },
      logError: {
        log_id: "",
        error_id: "",
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
      page_url: "",
    };
  },
  props: ["logDetailsId", "updateAllErrors"],
  components: {
    Pagination,
    NewError,
  },
  mounted() {
    if (window.location.pathname.substring(1, 7) === "coblog") {
      this.isCobDetails = true;
    }
    this.fetchAllErrors();
  },
  methods: {
    fetchAllErrors() {
      let vm = this;
      if (this.isCobDetails) {
        console.log('logDetailsId: ' + this.$props.logDetailsId);
        this.page_url = "/api/errors/unselected/" + this.logDetailsId;
      } else {
        this.page_url = "/api/errors";
      }
      fetch(this.page_url)
        .then((res) => res.json())
        .then((res) => {
          this.errors = res.data;
          this.filteredErrors = res.data;
          //Update Errors in Page for Pagination
          this.updateErrorsInPage();
        })
        .catch((err) => console.log(err));
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
      fetch(page_url, {
        method: "post",
        body: JSON.stringify(this.logError),
        headers: {
          "content-type": "application/json",
        },
      })
        .then((res) => res.json())
        .then((data) => {
          this.$emit("addLogError");
          this.fetchAllErrors();
        })
        .catch((err) => console.log(err));
    },
    refreshPage() {
      this.fetchAllErrors();
    },
  },
  computed: {
    resultQuery() {
      if (this.searchQuery) {
        //Save the result of queries in array filteredErrors
        this.filteredErrors = this.errors.filter((error) => {
          return (
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every((v) => error.component.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every((v) => error.sequence.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every((v) => error.problem.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every((v) => error.resolution.toLowerCase().includes(v))
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
    logDetailsId: function () {
      this.fetchAllErrors();
    },
    updateAllErrors: function () {
      this.fetchAllErrors();
    },
  },
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
