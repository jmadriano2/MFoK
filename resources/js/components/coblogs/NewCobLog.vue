<template>
  <div class="col-sm">
    <form-wizard
      @on-complete="onComplete"
      color="#6c7ae0"
      title="Close of Business Logger"
      subtitle="New CoB Log"
      finishButtonText="Start"
    >
      <tab-content title="Pre-CoB" icon="fa fa-cog">
        <PreCob></PreCob>
      </tab-content>
      <tab-content title="CoB Info" icon="fa fa-info">
        <div class="row">
          <div class="offset-sm-2 col-sm-8">
            <div class="card see-through">
              <div class="row">
                <div class="offset-sm-1 col-sm-10">
                  <div class="form-group mb-2 mt-1">
                    <label for="recipient-name" class="col-form-label mr-4"
                      >System:</label
                    >
                    <select
                      id="systems"
                      class="form-control"
                      v-model="selectedSystem"
                    >
                      <option
                        v-for="system in systems"
                        v-bind:key="system.id"
                        v-bind:value="{
                          id: system.id,
                          machine: system.machine,
                          system: system.system,
                          zone: system.zone,
                        }"
                      >
                        {{ system.machine }} - {{ system.system }}/{{
                          system.zone
                        }}
                      </option>
                    </select>
                  </div>

                  <div class="form-group mb-2">
                    <label for="recipient-name" class="col-form-label mr-4" disa
                      >Current Run Date:</label
                    >
                    <input
                      readonly
                      type="text"
                      class="form-control"
                      id="component-name"
                      v-model="rundate"
                      v-on:click="toggleRDCalendar()"
                    />
                    <v-date-picker
                      v-if="showRDCalendar"
                      mode="date"
                      v-model="rundate"
                      :model-config="modelConfig"
                    />
                  </div>

                  <div class="form-group mb-3">
                    <label for="recipient-name" class="col-form-label mr-4"
                      >Next Run Date:</label
                    >
                    <input
                      readonly
                      type="text"
                      class="form-control"
                      id="component-name"
                      v-model="nextRundate"
                      v-on:click="toggleNRDCalendar()"
                    />
                    <v-date-picker
                      v-if="showNRDCalendar"
                      mode="date"
                      v-model="nextRundate"
                      :model-config="modelConfig"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="Start Log" icon="fa fa-list">
        <div class="row">
          <div class="col-sm-6 offset-sm-3">
            <ul class="list-group">
              <li class="list-group-item">
                <div class="row">
                  <div class="col-sm-4">System:</div>
                  <div class="col-sm-6">{{ selectedSystem.system }}</div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="row">
                  <div class="col-sm-4">Machine:</div>
                  <div class="col-sm-6">{{ selectedSystem.machine }}</div>
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
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import PreCob from "./PreCob";

export default {
  components: {
    FormWizard,
    DatePicker,
    TabContent,
    PreCob,
  },
  data() {
    return {
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
    };
  },
  created() {
    this.fetchSystems();
  },
  methods: {
    onComplete: function () {
      alert("Yay. Done!");
    },
    fetchSystems(page_url) {
      let vm = this;
      page_url = page_url || "/api/systems";
      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          this.systems = res.data;
        })
        .catch((err) => console.log(err));
    },
    toggleRDCalendar() {
      this.showRDCalendar = !this.showRDCalendar;
    },
    toggleNRDCalendar() {
      this.showNRDCalendar = !this.showNRDCalendar;
    },
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
