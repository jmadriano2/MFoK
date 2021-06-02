<template>
  <div>
    <i class="fa fa-plus-square fa-2x" data-toggle="modal" data-target="#NewSystem"></i>

    <!-- New System Modal -->
    <div
      class="modal fade text-left"
      id="NewSystem"
      tabindex="-1"
      role="dialog"
      aria-labelledby="system"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Add New System</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addSystem">
              <div class="input-group row">
                <div class="form-group col-md">
                  <label for="recipient-name" class="col-form-label">Machine:</label>
                  <input type="text" class="form-control" maxlength="15" v-model="system.machine" />
                </div>
                <div class="form-group col-md">
                  <label for="recipient-name" class="col-form-label">System:</label>
                  <input type="text" class="form-control" maxlength="2" v-model="system.system" />
                </div>
                <div class="form-group col-md">
                  <label for="recipient-name" class="col-form-label">Zone:</label>
                  <input type="text" class="form-control" maxlength="2" v-model="system.zone" />
                </div>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Release:</label>
                <select
                  class="form-control"
                  aria-label="Default select example"
                  v-model="system.release"
                >
                  <option value selected disabled>Choose a Release</option>
                  <option value="Fusion Midas 2.1">Fusion Midas 2.1</option>
                  <option value="Fusion Midas 2.0">Fusion Midas 2.0</option>
                  <option value="Midas Plus 1.2.1 Service Pack 19">Midas Plus 1.2.1 Service Pack 19</option>
                  <option value="Midas R4.01.03">Midas R4.01.03</option>
                  <option value="Fusion Midas 1.4.11.06 IR01">Fusion Midas 1.4.11.06 IR01</option>
                  <option value="Fusion Midas 1.4.11.06 IR02">Fusion Midas 1.4.11.06 IR02</option>
                </select>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Rundate:</label>
                <input
                  readonly
                  type="text"
                  class="form-control"
                  id="component-name"
                  v-model="system.rundate"
                  v-on:click="toggleRDCalendar()"
                />
                <div class="row">
                  <div class="col-sm-4">
                    <v-date-picker
                      v-if="showRDCalendar"
                      mode="date"
                      v-model="system.rundate"
                      :model-config="modelConfig"
                    />
                  </div>
                  <div class="col-sm-8" v-on:click="toggleRDCalendar()"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-warning" @click="clearFields">Clear</button>
            <div>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button
                type="button"
                class="btn btn-primary"
                :disabled="disableConfirm"
                @click="addSystem"
                data-dismiss="modal"
              >Confirm</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from 'moment';

export default {
  data() {
    return {
      system: {
        id: "",
        machine: "",
        system: "",
        zone: "",
        release: "",
        rundate: ""
      },
      showRDCalendar: false,
      modelConfig: {
        type: "string",
        mask: "MMMM D, YYYY" // Uses 'iso' if missing
      }
    };
  },
  methods: {
    addSystem() {
      let page_url = window.location.origin + "/api/system";
      console.log(page_url);

      this.system.rundate = moment(this.system.rundate).format("YYYYMMDD");

      axios.get("/sanctum/csrf-cookie").then(response => {
        axios
          .post(page_url, this.system)
          .then(res => {
            this.system.machine = "";
            this.system.system = "";
            this.system.zone = "";
            this.system.release = "";
            this.system.rundate = "";
            alert("System Added");
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
      });
    },
    toggleRDCalendar() {
      this.showRDCalendar = !this.showRDCalendar;
    },
    clearFields() {
      this.system.machine = "";
      this.system.system = "";
      this.system.zone = "";
      this.system.release = "";
      this.system.rundate = "";
    }
  },
  computed: {
    disableConfirm: function() {
      if (
        this.system.machine !== "" &&
        this.system.system !== "" &&
        this.system.zone !== "" &&
        this.system.release !== "" &&
        this.system.rundate !== ""
      ) {
        return false;
      }
      return true;
    }
  }
};
</script>

<style>
i {
  cursor: pointer;
}

.modal-dialog {
  max-width: 35%;
}
</style>
