<template>
  <div class="col-sm-12">
    <h2>Errors Encountered</h2>
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
        Showing <b>{{ filteredCoblogErrors.length }}</b> Results
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <Pagination
          v-bind:errors="filteredCoblogErrors"
          v-bind:currentPage="currentPage"
          v-bind:pageSize="pageSize"
          v-on:pageUpdate="updatePage"
        >
        </Pagination>
      </div>
    </div>

    <div v-if="coblogErrors.length">
      <div
        class="card card-body mb-2"
        v-bind:key="coblogError.id"
        v-for="coblogError in resultQuery"
      >
        <h5>
          Component:
          <strong>{{ coblogError.component }}</strong> &nbsp;&nbsp;&nbsp; Seq.:
          <strong>{{ coblogError.sequence }}</strong>
        </h5>
        <hr />
        <h5>Problem:</h5>
        <p>
          <strong>{{ coblogError.problem }}</strong>
        </p>
        <h5>Resolution:</h5>
        <p>
          <strong>{{ coblogError.resolution }}</strong>
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from "../utility/Pagination.vue";

export default {
  data() {
    return {
      coblogErrors: [],
      searchQuery: "",
      pageSize: 5,
      pagination: {},
      currentPage: 0,
      pageSize: 5,
      coblogErrorsInPage: [],
      filteredCoblogErrors: [],
    };
  },
  components: {
    Pagination,
  },
  created() {
    this.fetchCobLogErrors();
  },
  methods: {
    fetchCobLogErrors(page_url) {
      let vm = this;
      page_url = page_url || "/api/coblog/" + this.$route.params.id + "/errors";
      console.log(page_url);
      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          this.coblogErrors = res.data;
        })
        .catch((err) => console.log(err));
    },
    updateCoblogErrorsInPage() {
      let startIndex = this.currentPage * this.pageSize;
      this.coblogErrorsInPage = this.filteredCoblogErrors.slice(
        startIndex,
        startIndex + this.pageSize
      );

      // if there are 0 errors, go back a page
      if (this.coblogErrorsInPage.length === 0 && this.currentPage > 0) {
        this.updatePage(this.currentPage - 1);
      }
    },
    updatePage(pageNumber) {
      this.currentPage = pageNumber;
      this.updateCoblogErrorsInPage();
    },
    refreshPage() {
      this.fetchErrors();
    },
  },
  computed: {
    resultQuery() {
      if (this.searchQuery) {
        //Save the result of queries in array filteredErrors
        this.filteredCoblogErrors = this.coblogErrors.filter((coblogError) => {
          return (
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every((v) => coblogError.component.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every((v) => coblogError.resolution.toLowerCase().includes(v))
          );
        });

        this.updateCoblogErrorsInPage();

        return this.coblogErrorsInPage;
      } else {
        this.filteredCoblogErrors = this.coblogErrors;
        this.updateCoblogErrorsInPage();
        return this.coblogErrorsInPage;
      }
    },
  },
};
</script>
<style scoped>
strong {
  color: green;
}
.card {
  background-color: rgba(245, 245, 245, 0.938);
}
.card-header,
.card-footer {
  opacity: 0.9;
}
</style>
