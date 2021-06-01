<template>
  <div>
    <i class="fa fa-plus-square fa-2x" data-toggle="modal" data-target="#newErrorResolution"></i>

    <!-- Modal -->
    <div
      class="modal fade text-left"
      id="newErrorResolution"
      tabindex="-1"
      role="dialog"
      aria-labelledby="errorResolution"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5
              class="Add New Error &amp; Resolution"
              id="errorResolution"
            >Add New Error &amp; Resolution</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addErrorResolution">
              <div class="input-group row">
                <div class="form-group col-md">
                  <label for="recipient-name" class="col-form-label">Component:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="component-name"
                    v-model="error.component"
                  />
                </div>
                <div class="form-group col-md">
                  <label for="recipient-name" class="col-form-label">Sequence:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="component-name"
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
              @click="addErrorResolution"
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
        resolution: "",
        created_at: ""
      },
      edit: false,
      editorOptionProblem: {
        debug: "info",
        placeholder: "Type in the CoB Error Description",
        readonly: true,
        modules: {
          toolbar: toolbarOptions
        },
        theme: "snow"
      },
      editorOptionResolution: {
        debug: "info",
        placeholder: "Type in the CoB Error Resolution",
        readonly: true,
        modules: {
          toolbar: toolbarOptions
        },
        theme: "snow"
      },
      delta: undefined
    };
  },
  components: {
    quillEditor
  },
  methods: {
    addErrorResolution() {
      if (this.edit === false) {
        //Add
        let page_url = window.location.origin + "/api/error";
        console.log(page_url);

        axios.get("/sanctum/csrf-cookie").then(response => {
          axios
            .post(page_url, this.error)
            .then(res => {
              this.error.component = "";
              this.error.sequence = "";
              this.error.problem = "";
              this.error.resolution = "";
              alert("Error Resolution Added");
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
      } else {
        //Update
      }
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
