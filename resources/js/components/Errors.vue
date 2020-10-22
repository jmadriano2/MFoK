<template>
  <div>
    <h2>Errors</h2>
    <div class="row">
      <div class="search-wrapper panel-heading col-sm-2 mb-2">
        <input
          class="form-control"
          type="text"
          v-model="searchQuery"
          placeholder="Search"
        />
      </div>
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li
          v-bind:class="[{ disabled: !pagination.prev_page_url }]"
          class="page-item"
        >
          <a
            class="page-link"
            href="#"
            @click="fetchErrors(pagination.prev_page_url)"
          >
            Previous
          </a>
        </li>
        <li class="page-item disabled">
          <a class="page-link text-dark" href="#">
            Page {{ pagination.current_page }} of {{ pagination.last_page }}
          </a>
        </li>
        <li
          v-bind:class="[{ disabled: !pagination.next_page_url }]"
          class="page-item"
        >
          <a
            class="page-link"
            href="#"
            @click="fetchErrors(pagination.next_page_url)"
          >
            Next
          </a>
        </li>
      </ul>
    </nav>
    <div v-if="errors.length">
    <div class="card card-body mb-2 col-sm-6"
      v-bind:key="error.id"
      v-for="error in resultQuery">
      <h3>{{ error.id }}: {{ error.component }}</h3>
      <p>{{ error.resolution }}</p>
    </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery:'',
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
  created() {
    console.log("yourmom");
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
      console.log(startIndex);
      this.errorsInPage = this.filteredErrors.slice(startIndex, startIndex + this.pageSize)

      // if there are 0 errors, go back a page
      if(this.errorsInPage.length === 0 && this.currentPage > 0) {
        this.updatePage(this.currentPage - 1);
      }
    },
    updatePage(pageNumber) {
      this.currentPage = pageNumber;
      this.updateErrorsInPage();
    }
  },
  computed: {
    resultQuery(){
      if(this.searchQuery){
      //Save the result of queries in array filteredErrors
      this.filteredErrors = this.errors.filter((error)=>{
        return this.searchQuery.toLowerCase().split(' ').every(v => error.component.toLowerCase().includes(v))
      });

      this.updateErrorsInPage();
      
      return this.errorsInPage;

      }else{
        this.filteredErrors = this.errors;
        this.updateErrorsInPage();
        return this.errorsInPage;
      }
    }
  }
};
</script>