<template>
  <div>
    <i
      class="fa fa-plus-square fa-2x"
      data-toggle="modal"
      data-target="#newErrorResolution"
    ></i>

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
            <h5 class="Add New Error &amp; Resolution" id="errorResolution">
              Add New Error &amp; Resolution
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addErrorResolution">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label"
                  >Component:</label
                >
                <input type="text" class="form-control" id="component-name"  v-model="error.component"/>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label"
                  >Resolution:</label
                >
                <textarea class="form-control" id="resolution-text" v-model="error.resolution"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary" @click="addErrorResolution" data-dismiss="modal">
              Confirm
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      error: {
        id: "",
        component: "",
        resolution: "",
        og_resolver: "Default User",
        created_at: "",
      },
      edit: false,
    }
  },
  methods: {
      addErrorResolution() {
          if(this.edit === false) {
              //Add
              let page_url = window.location.origin + '/api/error';
              console.log(page_url);
              fetch(page_url,{
                  method: 'post',
                  body: JSON.stringify(this.error),
                  headers: {
                      'content-type': 'application/json'
                  }
              })
              .then(res => res.json())
              .then(data => {
                  this.error.component = '';
                  this.error.resolution = '';
                  alert('Error Resolution Added');
                  this.$emit('refreshPage');
              })
              .catch(err => console.log(err));
          } else {
              //Update
          }
      }
  }
};
</script>

<style scoped>
</style>
