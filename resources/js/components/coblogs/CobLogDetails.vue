<template>
  <div class="col-sm-12">
    <form id="concludeCob" @submit.prevent="concludeCob">
      <div class="row">
        <div class="col-sm-8">
          <h1>Cob Log Details</h1>
        </div>
        <div class="col-sm-2 mt-2" v-if="!coblog.conclusion" >
          <select id="conclusions" class="form-control" v-model="concludeCobOption" >
            <option value="Full CoB">Full CoB</option>
            <option value="Reopened">Reopen</option>
          </select>
        </div>
        <div class="col-sm-1 mt-2" v-if="!coblog.conclusion" >
          <button type="submit" class="btn btn-success" :disabled="!concludeCobOption" >Conclude</button>
        </div>
      </div>
    </form>
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
          <div v-if="coblog.conclusion">
            Conclusion: <strong>{{ coblog.conclusion }}</strong>
          </div>
          <div v-else>
            Status: <strong>{{ coblog.status }}</strong>
          </div>
        </div>
        <div class="col-sm-4">
          Creator: <strong>{{ coblog.creator }}</strong>
        </div>
      </div>
    </div>
    <div class="row">
      <div v-bind:class="[isStatusComplete ? completeClass : incompleteClass]">
        <CobLogErrors
          :update-cob-errors="updateCobErrors"
          :conclusion="coblog.conclusion"
          v-on:removeLogError="refreshAllErrors"
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
      coblog: [],
      concludeCobOption: "",
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

      axios.get(page_url).then((res) => {
          this.coblog = res.data[0];
          console.log(this.coblog.status);
          if (this.coblog.status === "Completed") {
            this.isStatusComplete = true;
          }
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

    //   fetch(page_url)
    //     .then((res) => res.json())
    //     .then((res) => {
    //       this.coblog = res.data[0];
    //       console.log(this.coblog.status);
    //       if (this.coblog.status === "Completed") {
    //         this.isStatusComplete = true;
    //       }
    //     })
    //     .catch((err) => console.log(err));
    },
    concludeCob() {
        this.coblog.conclusion = this.concludeCobOption;
        this.coblog.status = "Completed";
        console.log(this.coblog);
        fetch('/api/coblog', {
          method: 'put',
          body: JSON.stringify(this.coblog),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.coblog.concludeCobOption = "";
            alert('CoB Concluded');
            this.fetchCobLog();
          })
          .catch(err => console.log(err));
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
