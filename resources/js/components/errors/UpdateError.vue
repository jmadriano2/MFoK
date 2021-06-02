<template>
  <div>
    <i
      class="fa fa-edit fa-2x"
      data-toggle="modal"
      :data-target="'#update' + error_id"
      v-if="selfReported"
      @click="updateFields()"
    ></i>

    <!-- Update Error and Resolution Modal -->
    <div
      class="modal fade text-left"
      :id="'update'+error_id"
      tabindex="-1"
      role="dialog"
      aria-labelledby="errorResolution"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Update Error &amp; Resolution</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="editErrorResolution">
              <div class="input-group row">
                <div class="form-group col-md">
                  <label for="recipient-name" class="col-form-label">Component:</label>
                  <input type="text" class="form-control" v-model="error.component" />
                </div>
                <div class="form-group col-md">
                  <label for="recipient-name" class="col-form-label">Sequence:</label>
                  <input
                    type="number"
                    class="form-control"
                    v-on:keyup="limitSequence"
                    v-model="error.sequence"
                  />
                </div>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Problem:</label>
                <quill-editor v-model="error.problem" :options="editorOptionProblem" />
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Resolution:</label>
                <quill-editor v-model="error.resolution" :options="editorOptionResolution" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button
              type="button"
              class="btn btn-primary"
              :disabled="disableConfirm"
              @click="updateErrorResolution"
              data-dismiss="modal"
            >Confirm</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { quillEditor } from "vue-quill-editor";
import "quill/dist/quill.snow.css";

export default {
  data() {
    let toolbarOptions = [
      ["bold", "italic", "underline", "strike"], // toggled buttons
      ["blockquote", "code-block"],

      [{ header: 1 }, { header: 2 }], // custom button values
      [{ list: "ordered" }, { list: "bullet" }],
      [{ script: "sub" }, { script: "super" }], // superscript/subscript
      [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
      [{ direction: "rtl" }], // text direction

      [{ size: ["small", false, "large", "huge"] }], // custom dropdown
      [{ header: [1, 2, 3, 4, 5, 6, false] }],

      [{ color: [] }, { background: [] }], // dropdown with defaults from theme
      [{ font: [] }],
      [{ align: [] }],

      ["clean"] // remove formatting button
    ];
    return {
      error: {
        id: "",
        component: "",
        sequence: "",
        problem: "",
        resolution: ""
      },
      editorOptionProblem: {
        debug: false,
        placeholder: "Type in the CoB Error Description",
        readonly: true,
        modules: {
          toolbar: toolbarOptions
        },
        theme: "snow"
      },
      editorOptionResolution: {
        debug: false,
        placeholder: "Type in the CoB Error Resolution",
        readonly: true,
        modules: {
          toolbar: toolbarOptions
        },
        theme: "snow"
      }
    };
  },
  props: {
    edit: Boolean,
    selfReported: Boolean,
    error_id: Number
  },
  components: {
    quillEditor
  },
  methods: {
    updateErrorResolution() {
      let page_url = "/api/error/" + this.error_id;
      console.log(page_url);

      axios.get("/sanctum/csrf-cookie").then(response => {
        axios
          .put(page_url, this.error)
          .then(res => {
            alert("Error Resolution Updated");
            console.log(res.data);
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
    updateFields() {
      let page_url = "/api/error/" + this.error_id;
      console.log(page_url);

      axios
        .get(page_url)
        .then(res => {
          this.error.id = res.data.id;
          this.error.component = res.data.component;
          this.error.sequence = res.data.sequence;
          this.error.problem = res.data.problem;
          this.error.resolution = res.data.resolution;
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
    limitSequence() {
      if (this.error.sequence.length > 5) {
        this.error.sequence = this.error.sequence.slice(0, 5);
      }
    }
  },
  computed: {
    disableConfirm: function() {
      if (
        this.error.component !== "" &&
        this.error.sequence !== "" &&
        this.error.problem !== "" &&
        this.error.resolution !== ""
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
  max-width: 70%;
}

.ql-editor {
  height: 10vh;
}
</style>
