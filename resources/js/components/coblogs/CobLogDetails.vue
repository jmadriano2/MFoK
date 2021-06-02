<template>
  <div class="col-sm-12">
    <h2>Cob Log Details</h2>
    <hr />

    <!-- CoB Log Details -->
    <div id="accordion" class="mb-2">
      <div class="card">
        <div class="card-header" id="headingCobLogDetails">
          <div class="row">
            <div class="col-sm-11">
              <h6>
                <strong>{{ coblog.description }}</strong>
              </h6>
            </div>
            <div class="col-sm-1">
              <i
                v-bind:class="[detailToggled ? chevronUp : chevronDown]"
                @click="detailToggled = !detailToggled"
                data-toggle="collapse"
                data-target="#collapseCobLogDetails"
                aria-expanded="true"
                aria-controls="collapseCobLogDetails"
                style="font-size: 1.5rem;"
              ></i>
            </div>
          </div>
        </div>

        <div
          id="collapseCobLogDetails"
          class="collapse show"
          aria-labelledby="headingCobLogDetails"
          data-parent="#accordion"
        >
          <div class="card card-body">
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
      incompleteClass: "col-sm-6",
      detailToggled: true,
      chevronUp: "fa fa-chevron-circle-up",
      chevronDown: "fa fa-chevron-circle-down"
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
    },
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
</style>
