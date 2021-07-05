<template>
    <div class="col-sm">
        <form-wizard
            @on-complete="uploadCobLog"
            color="#6c7ae0"
            title="Close of Business Logger"
            subtitle="Upload CoB Log"
            finishButtonText="Start">

            <!-- First tab -->
            <tab-content title="Upload File" icon="fa fa-upload">
                <form id="excelForm">
                    <input type="file" name="select_file">
                    <button type="button" class="btn btn-success" @click="uploadFile">Upload</button>
                </form>
            </tab-content>

            <!-- Second tab -->
            <tab-content
                title="Log Info &amp; Errors"
                icon="fa fa-info">

                <h1>PREVIEW</h1>

            </tab-content>

            <!-- Third tab -->
            <tab-content title="Start Log" icon="fa fa-list">
                <h1>SUMMARY</h1>
            </tab-content>
        </form-wizard>
    </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import moment from 'moment';
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import axios from "axios";

export default {
  components: {
    FormWizard,
    TabContent,
  },
  data() {
    return {
        logs: [],
    };
  },
  methods: {
    uploadFile() {
    //   console.log("upload file bruh");
      var $excelForm = $('#excelForm');
    //   console.log("upload file bruh 2");
      var data = new FormData(excelForm);

      axios.get('/sanctum/csrf-cookie').then(response => {
    //   console.log("upload file bruh 3");
        axios.post('api/coblog/import_excel', data)
            .then((res) => {
                this.logs = res.data;
                console.log(res);
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
    uploadCobLog() {
        console.log("lmfao");
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
