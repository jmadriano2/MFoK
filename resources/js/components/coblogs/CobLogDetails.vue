<template>
  <div class="col-sm-12">
    <h1>Cob Log Details</h1>
    <hr />

    <!-- CoB Log Details -->
    <div class="card card-body mb-2">
      <div class="row">
        <div class="col-sm-3">
          <h6>
            System:
            <strong>
              {{ coblog.system.machine }} | {{ coblog.system.system }}/{{
              coblog.system.zone
              }}
            </strong>
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
          <div v-if="coblog.conclusion">
            Conclusion:
            <strong>{{ coblog.conclusion }}</strong>
          </div>
          <div v-else>
            Status:
            <strong>{{ coblog.status }}</strong>
          </div>
        </div>
        <div class="col-sm-4">
          Creator:
          <strong>{{ coblog.logger.name }}</strong>
        </div>
      </div>
    </div>

    <!-- List of Errors Encountered and/or All Errors -->
    <div class="row">
      <div v-bind:class="[isStatusComplete ? completeClass : incompleteClass]">
        <CobLogErrors
          :update-cob-errors="updateCobErrors"
          :coblog="coblog"
          :isStatusComplete="isStatusComplete"
          v-on:removeLogError="refreshAllErrors"
          v-on:refreshPage="fetchCobLog"
        ></CobLogErrors>
      </div>
      <div class="col-sm-6" v-if="!isStatusComplete">
        <Errors
          :log-details-id="coblog.id"
          :update-all-errors="updateAllErrors"
          v-on:addLogError="refreshCobLogErrors"
        ></Errors>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import CobLogErrors from "./CobLogErrors.vue";
import Errors from "../errors/Errors.vue";
import axios from "axios";

export default {
  data() {
    return {
      coblog: {
        system: {
          machine: "",
          system: "",
          zone: ""
        },
        logger: {
          name: ""
        }
      },
      updateCobErrors: 0,
      updateAllErrors: 0,
      isStatusComplete: false,
      completeClass: "col-sm-12",
      incompleteClass: "col-sm-6"
    };
  },
  components: {
    CobLogErrors,
    Errors
  },
  mounted() {
    this.fetchCobLog();
  },
  methods: {
    fetchCobLog(page_url) {
      let vm = this;
      page_url = page_url || "/api/coblog/" + this.$route.params.id;
      console.log(page_url + " urmum");

      axios
        .get(page_url)
        .then(res => {
          this.coblog = res.data[0];
          console.log(this.coblog.status);
          if (this.coblog.status === "Completed") {
            this.isStatusComplete = true;
          }
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
    refreshCobLogErrors() {
      this.updateCobErrors += 1;
    },
    refreshAllErrors() {
      this.updateAllErrors += 1;
    }
  },
  filters: {
    formatDate: function(value) {
      if (!value) return "";
      return moment(String(value)).format("dddd, MMMM D, YYYY");
    }
  }
};
</script>
<style scoped>
strong {
  color: green;
}
</style>
