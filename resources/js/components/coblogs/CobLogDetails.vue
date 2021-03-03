<template>
  <div class="col-sm-12">
    <h1>Cob Log Details</h1>
    <hr />
    <div class="card card-body mb-2">
      <div class="row">
        <div class="col-sm-3">
          <h6>
            System:
            <strong
              >{{ coblog.machine }} | {{ coblog.system }}/{{
                coblog.zone
              }}</strong
            >
          </h6>
        </div>
        <div class="col-sm-4">
          <h6>
            Runday:
            <strong>{{ coblog.runday | formatDate }}</strong>
          </h6>
        </div>
        <div class="col-sm-4">
          <h6>
            Next Working Day:
            <strong>{{ coblog.next_working_day | formatDate }}</strong>
          </h6>
        </div>
        <div class="col-sm-3">
          Status: <strong>{{ coblog.status }}</strong>
        </div>
        <div class="col-sm-4">
          Creator: <strong>{{ coblog.creator }}</strong>
        </div>
      </div>
    </div>
    <div class="row">
      <div v-bind:class="[isStatusComplete ? completeClass : incompleteClass]">
        <CobLogErrors :update-cob-errors="updateCobErrors" v-on:removeLogError="refreshAllErrors"></CobLogErrors>
      </div>
      <div class="col-sm-6" v-if="!isStatusComplete">
        <Errors :log-details-id="coblog.id" :update-all-errors="updateAllErrors" v-on:addLogError="refreshCobLogErrors"></Errors>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import CobLogErrors from "./CobLogErrors.vue";
import Errors from "../errors/Errors.vue";

export default {
  data() {
    return {
      coblog: [],
      updateCobErrors: 0,
      updateAllErrors: 0,
      isStatusComplete: false,
      completeClass: "col-sm-12",
      incompleteClass: "col-sm-6",
    };
  },
  components: {
    CobLogErrors,
    Errors,
  },
  created() {
    this.fetchCobLog();
  },
  methods: {
    fetchCobLog(page_url) {
      let vm = this;
      page_url = page_url || "/api/coblog/" + this.$route.params.id;
      console.log(page_url);
      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          this.coblog = res.data[0];
          console.log(this.coblog.status);
          if (this.coblog.status === "Completed") {
            this.isStatusComplete = true;
          }
        })
        .catch((err) => console.log(err));
    },
    refreshCobLogErrors() {
        this.updateCobErrors += 1;
    },
    refreshAllErrors() {
        this.updateAllErrors += 1;
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
strong {
  color: green;
}
</style>
