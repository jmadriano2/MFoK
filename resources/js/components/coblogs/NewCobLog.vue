<template>
  <div class="col-sm">
    <form-wizard
      @on-complete="onComplete"
      color="#6c7ae0"
      title="Close of Business Logger"
      subtitle="New CoB Log"
      finishButtonText="Create"
    >
      <tab-content title="CoB Info" icon="fa fa-info">
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <div class="form-group mb-2">
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
              <input type="text" class="form-control" id="component-name" />
            </div>

            <div class="form-group mb-2">
              <label for="recipient-name" class="col-form-label mr-4"
                >Zone:</label
              >
              <input type="text" class="form-control" id="component-name" />
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="CoB Details" icon="fa fa-cog">
        My second tab content
      </tab-content>
      <tab-content title="Summary" icon="fa fa-list">
        Yuhuuu! This seems pretty damn simple
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