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
        <div class="row">
          <div class="col-sm-6 offset-sm-3">
            <ul class="list-group">
              <li class="list-group-item">
                1.0 - Check for Outstanding Transactions
              </li>
              <li class="list-group-item">
                2.0 - Check for objects in xxINVLIB that could affect CoB output
              </li>
              <li class="list-group-item">
                3.0 - Check for requested Halts for bug investigation
              </li>
              <li class="list-group-item">4.0 - Run VALD</li>
              <li class="list-group-item">
                5.0 - Check Queue Managers and Channels are Active
              </li>
              <li class="list-group-item">6.0 - Check System Status</li>
              <li class="list-group-item">
                7.0 - Sign-in to BFMI to check if WAS is up
              </li>
              <li class="list-group-item">8.0 - Clear Message Queues</li>
            </ul>
          </div>
        </div>
      </tab-content>
      <tab-content title="CoB Info" icon="fa fa-info">
        <div class="row">
          <div class="offset-sm-2 col-sm-8">
            <div class="card see-through">
              <div class="row">
                <div class="offset-sm-1 col-sm-10">
                  <div class="form-group mb-2 mt-1">
                    <label for="recipient-name" class="col-form-label mr-4"
                      >Machine:</label
                    >
                    <select id="cars" name="cars">
                      <option value="1">MNA</option>
                      <option value="2">MNE</option>
                      <option value="3">MNF</option>
                      <option value="4">MNP</option>
                      <option value="4">MNQ</option>
                    </select>
                  </div>

                  <div class="form-group mb-2">
                    <label for="recipient-name" class="col-form-label mr-4"
                      >System:</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="component-name"
                    />
                  </div>

                  <div class="form-group mb-2">
                    <label for="recipient-name" class="col-form-label mr-4"
                      >Zone:</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="component-name"
                    />
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

export default {
  components: {
    FormWizard,
    TabContent,
  },
  methods: {
    onComplete: function () {
      alert("Yay. Done!");
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
