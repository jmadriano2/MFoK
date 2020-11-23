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
                    <select id="systems" class="form-control">
                      <option
                        v-for="system in systems"
                        v-bind:key="system.id"
                        value="system.id"
                      >
                        {{ system.machine }} - {{ system.system }}/{{ system.zone }}
                      </option>
                    </select>
                  </div>

                  <div class="form-group mb-2">
                    <label for="recipient-name" class="col-form-label mr-4"
                      >Current Run Date:</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="component-name"
                    />
                  </div>

                  <div class="form-group mb-3">
                    <label for="recipient-name" class="col-form-label mr-4"
                      >Next Run Date:</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="component-name"
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
              <li class="list-group-item">Machine:</li>
              <li class="list-group-item">System:</li>
              <li class="list-group-item">Zone:</li>
              <li class="list-group-item">Current Run Date:</li>
              <li class="list-group-item">Next Run Date:</li>
            </ul>
          </div>
        </div>
      </tab-content>
    </form-wizard>
  </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import PreCob from "./PreCob";

export default {
  components: {
    FormWizard,
    TabContent,
    PreCob,
  },
  data() {
    return {
      systems: [],
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
      console.log("I was here");
      let vm = this;
      page_url = page_url || "/api/systems";
      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          this.systems = res.data;
        })
        .catch((err) => console.log(err));
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
