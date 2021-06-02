<template>
    <nav aria-label="Page navigation example" >
      <ul class="pagination" v-if="totalPages() > 1">
        <li
          v-bind:class="[{ disabled: onFirstPage() }]"
          class="page-item"
        >
          <a
            class="page-link"
            href="#"
            v-on:click="updatePage(currentPage - 1)"
          >
            Previous
          </a>
        </li>
        <li class="page-item disabled">
          <a class="page-link text-dark" href="#">
            Page {{ currentPage + 1 }} of {{ totalPages() }}
          </a>
        </li>
        <li
          v-bind:class="[{ disabled: onLastPage() }]"
          class="page-item"
        >
          <a
            class="page-link"
            href="#"
            v-on:click="updatePage(currentPage + 1)"
          >
            Next
          </a>
        </li>
      </ul>
    </nav>
</template>

<script>
export default {
    props: ['items', 'currentPage', 'pageSize'],
    methods: {
        updatePage(pageNumber) {
            this.$emit('pageUpdate', pageNumber);
        },
        totalPages() {
            return Math.ceil(this.items.length / this.pageSize);
        },
        onFirstPage() {
            return this.currentPage < 1 ? true : false;
        },
        onLastPage() {
            let tp = this.totalPages() - 1;
            return this.currentPage == tp ? true : false;
        },
    }
}
</script>
