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
      <div class="col-sm-1 offset-sm-5 text-right">
        <i
          class="fa fa-minus-square fa-2x"
          v-on:click="removeActive = !removeActive"
          v-if="!conclusion"
        ></i>
      </div>
    </div>

    <div v-if="coblogErrors.length">
      <div
        class="card card-body mb-2"
        v-bind:key="coblogError.id"
        v-for="coblogError in resultQuery"
      >
        <div class="row">
          <div v-bind:class="[removeActive ? RAClass : notRAClass]">
            <h5>
              Component:
              <strong>{{ coblogError.component }}</strong> &nbsp;&nbsp;&nbsp;
              Seq.:
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
          <div
            v-if="removeActive"
            class="col-sm-1 l-border d-flex align-items-center justify-content-center"
          >
            <div
              style="font-size: 4rem"
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
    };
  },
  props: ["updateCobErrors", "conclusion"],
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

      axios.get(page_url).then((res) => {
          this.coblogErrors = res.data;
          console.log("fetchLogErrors(): " + this.coblogErrors);
      })
      .catch(function (error) {
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
      let page_url = '/api/coblog/'+ log_id + '/' + error_id;
      console.log('gay' + log_id)

      axios.delete(page_url).then((res) => {
          this.fetchCobLogErrors();
          this.$emit("removeLogError");
      })
      .catch(function (error) {
            if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
            }
      });

    //   fetch(`/api/coblog/${log_id}/${error_id}`, {
    //     method: "delete",
    //   })
    //     .then((res) => res.json())
    //     .then((data) => {
    //       this.fetchCobLogErrors();
    //       this.$emit("removeLogError");
    //     })
    //     .catch((err) => console.log(err));
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
  watch: {
    updateCobErrors: function () {
      this.fetchCobLogErrors();
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
