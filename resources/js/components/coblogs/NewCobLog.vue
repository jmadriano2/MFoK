<template>
    <div class="col-sm">
        <form-wizard
            @on-complete="addNewCobLog"
            color="#6c7ae0"
            title="Close of Business Logger"
            subtitle="New CoB Log"
            finishButtonText="Start">

            <!-- First tab -->
            <tab-content title="Pre-CoB" icon="fa fa-cog">
                <PreCob></PreCob>
            </tab-content>

            <!-- Second tab -->
            <tab-content
                title="CoB Info"
                icon="fa fa-info"
                :beforeChange="validateSystem">

                <div class="row">
                    <div class="offset-sm-2 col-sm-8">
                        <div class="card see-through">
                            <div class="row">
                                <div class="offset-sm-1 col-sm-10">
                                    <!-- Description field -->
                                    <div class="form-group mb-2 mt-1">
                                        <label
                                            for="recipient-name"
                                            class="col-form-label mr-4">
                                            Description:
                                        </label>
                                        <!-- System error -->
                                        <div
                                            class="alert alert-danger d-none"
                                            role="alert"
                                            :class="{'d-block': hasSystemError}">
                                                {{ SystemErrorMessage }}
                                        </div>
                                        <!-- System dropdown -->
                                        <input type="text" class="form-control" maxlength="100" v-model="coblog.description" />
                                    </div>

                                    <!-- System field -->
                                    <div class="form-group mb-2 mt-1">
                                        <label
                                            class="col-form-label mr-4">
                                            System:
                                        </label>
                                        <!-- System error -->
                                        <div
                                            class="alert alert-danger d-none"
                                            role="alert"
                                            :class="{'d-block': hasSystemError}">
                                                {{ SystemErrorMessage }}
                                        </div>
                                        <!-- System dropdown -->
                                        <select
                                            id="systems"
                                            class="form-control"
                                            v-model="selectedSystem"
                                            @change="onSystemChange()">
                                            <option
                                                v-for="system in systems"
                                                v-bind:key="system.id"
                                                v-bind:value="{
                                                    id: system.id,
                                                    machine: system.machine,
                                                    system: system.system,
                                                    zone: system.zone,
                                                    rundate: system.rundate,}">
                                                        {{ system.machine }} - {{ system.system }}/{{system.zone}} | {{system.release}}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Rundate field -->
                                    <div class="form-group mb-2">
                                        <label class="col-form-label mr-4">
                                            Current Run Date:
                                        </label>
                                        <!-- Rundate error -->
                                        <div
                                            class="alert alert-danger d-none"
                                            role="alert"
                                            :class="{'d-block': hasRDError}">
                                                {{ RDErrorMessage }}
                                        </div>
                                        <input
                                            readonly
                                            type="text"
                                            class="form-control"
                                            id="component-name"
                                            v-model="rundate"
                                            v-on:click="toggleRDCalendar()"/>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <v-date-picker
                                                    v-if="showRDCalendar"
                                                    mode="date"
                                                    v-model="rundate"
                                                    :model-config="modelConfig"/>
                                            </div>
                                            <div
                                                class="col-sm-8"
                                                v-on:click="toggleRDCalendar()">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="col-form-label mr-4">
                                            Next Run Date:
                                        </label>
                                        <!-- Next Rundate error -->
                                        <div
                                            class="alert alert-danger d-none"
                                            role="alert"
                                            :class="{'d-block': hasNRDError}">
                                                {{ NRDErrorMessage }}
                                        </div>
                                        <input
                                            readonly
                                            type="text"
                                            class="form-control"
                                            id="component-name"
                                            v-model="nextRundate"
                                            v-on:click="toggleNRDCalendar()"/>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <v-date-picker
                                                    v-if="showNRDCalendar"
                                                    mode="date"
                                                    v-model="nextRundate"
                                                    :model-config="modelConfig"/>
                                            </div>
                                            <div
                                                class="col-sm-8"
                                                v-on:click="toggleNRDCalendar()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tab-content>

            <!-- Third tab -->
            <tab-content title="Start Log" icon="fa fa-list">
                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4">Description:</div>
                                <div class="col-sm-6">{{ coblog.description }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4">Machine:</div>
                                <div class="col-sm-6">{{ selectedSystem.machine }}</div>
                            </div>
                        </li>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">System:</div>
                                    <div class="col-sm-6">{{ selectedSystem.system }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">Zone:</div>
                                    <div class="col-sm-6">{{ selectedSystem.zone }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">Current Run Date:</div>
                                    <div class="col-sm-6">{{ rundate }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">Next Run Date:</div>
                                    <div class="col-sm-6">{{ nextRundate }}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </tab-content>
        </form-wizard>
    </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import moment from 'moment';
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import PreCob from "./PreCob";
import axios from "axios";

export default {
  components: {
    FormWizard,
    DatePicker,
    TabContent,
    PreCob,
  },
  data() {
    return {
      hasSystemError: false,
      hasRDError: false,
      hasNRDError: false,
      SystemErrorMessage: "",
      RDErrorMessage: "",
      NRDErrorMessage: "",
      isClearedToProceed: false,
      systems: [],
      selectedSystem: "",
      rundate: "",
      showRDCalendar: false,
      nextRundate: "",
      showNRDCalendar: false,
      modelConfig: {
        type: "string",
        mask: "MMMM D, YYYY", // Uses 'iso' if missing
      },
      coblog: {
          id: "",
          system_id: "",
          description: "",
          runday: "",
          next_working_day: "",
          status: "",
          runtime: "",
          conclusion: "",
          creator: "",
      },
      returnData: [],
    };
  },
  created() {
    this.fetchSystems();
  },
  methods: {
    fetchSystems(page_url) {
      let vm = this;
      page_url = page_url || "/api/systems";

      axios.get(page_url).then((res) => {
          console.log(res);
          this.systems = res.data;
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
    toggleRDCalendar() {
      this.showRDCalendar = !this.showRDCalendar;
    },
    toggleNRDCalendar() {
      this.showNRDCalendar = !this.showNRDCalendar;
    },
    addNewCobLog() {
      this.coblog.system_id = this.selectedSystem.id;
      this.coblog.runday = moment(this.rundate).format('YYYYMMDD');
      this.coblog.next_working_day = moment(this.nextWorkingDay).format('YYYYMMDD');
      this.coblog.status = 'Ongoing';
      this.coblog.runtime = 0;

      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/api/coblog', this.coblog).then((res) => {
            alert("New Cob Log Added");
          let $newCobUrl = 'coblog/' + res.data.id + '/details';
          this.$router.push($newCobUrl);
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
      });
    },
    validateSystem() {
        // Selected System can't be blank
        if (this.selectedSystem == '') {
            this.hasSystemError = true;
            this.SystemErrorMessage = 'System is required.';
        } else {
            this.hasSystemError = false;
        }
        // Rundate can't be blank
        if (this.rundate == '') {
            this.hasRDError = true;
            this.RDErrorMessage = 'Rundate is required.';
        } else {
            this.hasRDError = false;
        }
        // Next Rundate can't be blank
        if (this.nextRundate == '') {
            this.hasNRDError = true;
            this.NRDErrorMessage = 'Next Rundate is required.';
        } else {
            this.hasNRDError = false;
            // Next Rundate can't be before Rundate
            let RDMoment = moment(this.rundate);
            let NRDMoment = moment(this.nextRundate);
            if (NRDMoment.isBefore(RDMoment)) {
                this.hasNRDError = true;
                this.NRDErrorMessage = 'Next Run Date can\'t be before Current Run Date.';
            }
            // Next Rundate can't be same as Rundate
            if (NRDMoment.isSame(RDMoment, 'day')) {
                this.hasNRDError = true;
                this.NRDErrorMessage = 'Next Run Date can\'t be the same as Current Run Date.';
            }
        }

        console.log('System:' + this.selectedSystem);
        console.log('Rundate:' + this.rundate);
        console.log('Next Rundate:' + this.nextRundate);

        if (this.hasSystemError
            | this.hasRDError
            | this.hasNRDError) {
            this.isClearedToProceed = false;
        } else {
            this.isClearedToProceed = true;
        }

        return this.isClearedToProceed;
    },
    //below is a filler method which has no real use
    onSystemChange() {
      console.log(this.selectedSystem);
      let systemRundateMoment = moment(this.selectedSystem.rundate, 'YYYYMMDD');
      this.rundate = systemRundateMoment.format('MMMM D, YYYY');
      systemRundateMoment = systemRundateMoment.add(1, 'days');
      this.nextRundate = systemRundateMoment.format('MMMM D, YYYY');
    }
  },
};
</script>

<style scoped>
.list-group-item {
  background-color: whitesmoke;
  font-weight: bold;
  opacity: 0.9;
}

.see-through {
  background-color: whitesmoke;
  opacity: 0.9;
}
</style>
