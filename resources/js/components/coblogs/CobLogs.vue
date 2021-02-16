<template>
  <div class="col-sm-8">
    <h1>All Cob Logs</h1>
    <div v-if="coblogs.length">
      <div
        class="card card-body mb-2"
        v-bind:key="coblog.id"
        v-for="coblog in coblogs"
      >
        <div class="row">
          <div class="col-sm-10">
            <h4>System:</h4>
            <h5>
              {{ coblog.machine }} | {{ coblog.system }}/{{ coblog.zone }}
            </h5>
            <h4>Runday:</h4>
            <h5>{{ coblog.runday | formatDate }}</h5>
            <h4>Next Working Day:</h4>
            <h5>{{ coblog.next_working_day | formatDate }}</h5>
            <p class="mt-3">
              <strong>Status: {{ coblog.status }}</strong>
            </p>
            <p>
              <strong>Creator: {{ coblog.creator }}</strong>
            </p>
          </div>
          <div
            class="col-sm-2 expand d-flex align-items-center justify-content-center"
          >
            <router-link
              :to="{ name: 'cobLogDetails', params: { id: coblog.id } }"
            >
              <div style="font-size: 4rem">
                <i class="fa fa-chevron-right fa-lg" style="color: indigo"> </i>
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
        createdAt: "",
      },
    };
  },
  created() {
    this.fetchCobLogs();
  },
  methods: {
    fetchCobLogs(page_url) {
      let vm = this;
      page_url = page_url || "/api/coblogs";
      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          this.coblogs = res.data;
        })
        .catch((err) => console.log(err));
    },
  },
  filters: {
    formatDate: function (value) {
      if (!value) return "";
      return moment(String(value)).format("dddd, MMMM D, YYYY");
    },
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
.expand {
  border-left: 3px solid indigo;
}
</style>
