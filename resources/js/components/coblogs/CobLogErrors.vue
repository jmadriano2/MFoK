<template>
  <div class="col-sm-11">
    <form id="concludeCob" @submit.prevent="concludeCob">
      <div class="row">
        <div class="col-sm-8">
          <h3>Errors Encountered</h3>
        </div>
        <div class="col-sm-3 mt-2" v-if="!coblog.conclusion">
          <select id="conclusions" class="form-control" v-model="concludeCobOption">
            <option value="Full CoB">Full CoB</option>
            <option value="Reopened">Reopen</option>
          </select>
        </div>
        <div class="col-sm-1 mt-2" v-if="!coblog.conclusion">
          <button type="submit" class="btn btn-success" :disabled="!concludeCobOption">Conclude</button>
        </div>
      </div>
    </form>

    <!-- Search Bar -->
    <div class="row">
      <div class="search-wrapper panel-heading col mb-2">
        <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
      </div>
      <div class="col mt-2">
        Showing
        <b>{{ filteredCoblogErrors.length }}</b> Results
      </div>
    </div>

    <!-- Pagination -->
    <div class="row">
      <div class="col-sm-8">
        <Pagination
          v-bind:items="filteredCoblogErrors"
          v-bind:currentPage="currentPage"
          v-bind:pageSize="pageSize"
          v-on:pageUpdate="updatePage"
        ></Pagination>
      </div>
      <div class="col-sm-1 offset-sm-3 text-right">
        <i
          class="fa fa-minus-square fa-2x"
          v-on:click="removeActive = !removeActive"
          v-if="!coblog.conclusion"
        ></i>
      </div>
    </div>

    <!-- List of Errors Encountered -->
    <div v-if="coblogErrors.length">
      <div
        class="card card-body mb-3 border-primary"
        v-bind:key="coblogError.id"
        v-for="coblogError in resultQuery"
      >
        <div class="row">
          <div v-bind:class="[removeActive ? RAClass : notRAClass]">
            <h6>
              Component:
              <strong>{{ coblogError.component }}</strong> &nbsp;&nbsp;&nbsp;
              Seq.:
              <strong>{{ coblogError.sequence }}</strong>
            </h6>
            <hr />
            <h6>Problem:</h6>
            <div v-html="coblogError.problem" class="mb-3 ml-4"></div>
            <h6>Resolution:</h6>
            <div v-html="coblogError.resolution" class="ml-4"></div>
            <hr />
            <h6>Resolved By: {{ coblogError.resolver.name }}</h6>
          </div>
          <div
            v-if="removeActive"
            class="col-sm-1 l-border d-flex align-items-center justify-content-center"
          >
            <div
              style="font-size: 3rem"
              @click="
                removeCoblogError(coblogError.pivot.log_id, coblogError.pivot.error_id)
              "
            >
              <i class="fa fa-angle-double-right customRightArrow"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from "../utility/Pagination.vue";
import axios from "axios";

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
      removeActive: false,
      RAClass: "col-sm-11",
      notRAClass: "col-sm-12",
      notFillRow: "col-sm-10",
      fillRow: "col-sm-12",
      concludeCobOption: ""
    };
  },
  props: ["updateCobErrors", "coblog", "isStatusComplete"],
  components: {
    Pagination
  },
  created() {
    this.fetchCobLogErrors();
  },
  methods: {
    fetchCobLogErrors(page_url) {
      let vm = this;
      page_url = page_url || "/api/coblog/" + this.$route.params.id + "/errors";

      axios
        .get(page_url)
        .then(res => {
          this.coblogErrors = res.data;
          console.log("fetchLogErrors(): " + this.coblogErrors);
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
    removeCoblogError(log_id, error_id) {
      let page_url = "/api/coblog/" + log_id + "/" + error_id;
      console.log("gay" + log_id);

      axios
        .delete(page_url)
        .then(res => {
          this.fetchCobLogErrors();
          this.$emit("removeLogError");
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
    concludeCob() {
      this.coblog.conclusion = this.concludeCobOption;
      this.coblog.status = "Completed";
      console.log(this.coblog);

      axios
        .put("/api/coblog/" + this.coblog.id, this.coblog)
        .then(res => {
          this.coblog.concludeCobOption = "";
          alert("CoB Concluded");
          this.removeActive = false;
          this.$emit("refreshPage");
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
    }
  },
  computed: {
    resultQuery() {
      if (this.searchQuery) {
        //Save the result of queries in array filteredErrors
        this.filteredCoblogErrors = this.coblogErrors.filter(coblogError => {
          return (
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblogError.component.toLowerCase().includes(v)) ||
            this.searchQuery
              .toLowerCase()
              .split(" ")
              .every(v => coblogError.resolution.toLowerCase().includes(v))
          );
        });

        this.updateCoblogErrorsInPage();

        return this.coblogErrorsInPage;
      } else {
        this.filteredCoblogErrors = this.coblogErrors;
        this.updateCoblogErrorsInPage();
        return this.coblogErrorsInPage;
      }
    }
  },
  watch: {
    updateCobErrors: function() {
      this.fetchCobLogErrors();
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
.card {
  background-color: rgba(245, 245, 245, 0.938);
}
.card-header,
.card-footer {
  opacity: 0.9;
}
.l-border {
  border-left: 3px solid rgb(230, 92, 133);
}
.customRightArrow {
  color: rgb(212, 83, 122);
}
.customRightArrow:hover {
  color: rgb(241, 120, 156);
}
.customRightArrow:active {
  color: rgb(230, 32, 92);
}
</style>
