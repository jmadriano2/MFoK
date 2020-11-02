<template>
  <div>
    <h2>CoB Errors</h2>
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
        <h3>{{ error.id }}: {{ error.component }}</h3>
        <p>
          <strong>{{ error.resolution }}</strong>
        </p>
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
        resolution: "",
        og_resolver: "",
        created_at: "",
      },
      error_id: "",
      pageSize: 5,
      pagination: {},
      currentPage: 0,
      pageSize: 5,
      errorsInPage: [],
      filteredErrors: [],
    };
  },
  components: {
    Pagination,
    NewError,
  },
  created() {
    this.fetchErrors();
  },
  methods: {
    fetchErrors(page_url) {
      let vm = this;
      page_url = page_url || "/api/errors";
      fetch(page_url)
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
    refreshPage() {
      this.fetchErrors();
    }
  },
  computed: {
    resultQuery() {
      if (this.searchQuery) {
        //Save the result of queries in array filteredErrors
        this.filteredErrors = this.errors.filter((error) => {
          return this.searchQuery
            .toLowerCase()
            .split(" ")
            .every((v) => error.component.toLowerCase().includes(v)) ||
            this.searchQuery
            .toLowerCase()
            .split(" ")
            .every((v) => error.resolution.toLowerCase().includes(v));
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
};
</script>

<style scoped>
.card {
  background-color: rgba(245, 245, 245, 0.4);
}
.card-header,
.card-footer {
  opacity: 0.7;
}
</style>