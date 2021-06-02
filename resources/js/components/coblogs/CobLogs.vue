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
          <div class="col-sm-5">
            <h4>System:</h4>
            <h5>
              {{ coblog.system.machine }} | {{ coblog.system.system }}/{{ coblog.system.zone }}
            </h5>
            <h4>Release:</h4>
            <h5>
              {{ coblog.system.release }}
            </h5>
            <p class="mt-3">
              <strong>Status: {{ coblog.status }}</strong>
            </p>
          </div>
          <div class="col-sm-5">
            <h4>Runday:</h4>
            <h5>{{ coblog.runday | formatDate }}</h5>
            <h4>Next Working Day:</h4>
            <h5>{{ coblog.next_working_day | formatDate }}</h5>
            <p class="mt-3">
              <strong>Creator: {{ coblog.logger.name }}</strong>
            </p>
          </div>
          <div
            class="col-sm-2 expand d-flex align-items-center justify-content-center"
          >
            <router-link
              :to="{ name: 'cobLogDetails', params: { id: coblog.id } }"
            >
              <div style="font-size: 4rem">
                <i class="fa fa-chevron-right fa-lg customRightArrow"> </i>
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

      console.log(page_url);
      axios.get(page_url).then((res) => {
          console.log(res);
          this.coblogs = res.data;
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
