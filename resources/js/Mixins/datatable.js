export default {
  data() {
    return {
      items: [],
      total: 0,
      filtered: 0,
      search: "",
      start: 0,
      length: 10,
      order: "",
      order_by: "name",
      order_type: "desc",
      submiting: false,
      modalId: "",
      modalTitle: "",
      modalTextConfirm: "",
      modalTextCancel: "Cancel",
      modalDeleteId: "",
      errorMsg: {
        name: "",
        description: "",
      },
      textDelete: "",
    }
  },
  mounted() {
    this.modalDeleteId = `${this.model}-delete-modal`
    this.initTable();
  },
  methods: {
    initTable() {
      let meta = {
        length: this.length,
        start: this.start,
        search: this.search,
        order_by: this.order_by,
        order_type: this.order_type,
      };
      this.$api.get(this.model, meta).then((response) => {
        if (response.status == 200 && response.data && response.data.data) {
          this.items = response.data.data;
          this.filtered = response.data.recordsFiltered;
          this.total = response.data.recordsTotal;
        }
      });
    },
    editItem(item) {
      this.modalId = `${this.model}-edit-modal`;
      this.modalTitle = `Edit ${this.model}`;
      this.modalTextConfirm = "Update";
      this.selectedPermission = item;
      this.showModal();
    },
    addItem() {
      this.modalId = `${this.model}-add-modal`;
      this.modalTitle = `Add ${this.model}`;
      this.modalTextConfirm = "Create";
      this.showModal();
    },
    showModal() {
      this.$nextTick(() => {
        let modal = document.getElementById(this.modalId);
        if (!modal.open) {
          modal.showModal();
        }
      })
    },
    deleteItem(item) {
      this.textDelete =
        'Are you sure to delete permisison <span class="text-red-500 font-semibold">' +
        item.name +
        "</span> ?";
      this.selectedPermission = item;
      this.$nextTick(() => {
        let modal = document.getElementById(this.modalDeleteId);
        if (!modal.open) {
          modal.showModal();
        }
      })
    },
    confirmDelete() {
      this.$api
        .delete(this.model, this.selectedPermission.id)
        .then((response) => {
          this.submiting = false;
          if (
            response.status == 200 &&
            response.data &&
            response.data.code == 0
          ) {
            document.getElementById(this.modalDeleteId).close();
            this.$notify({
              title: "Notify",
              text: "Success",
              type: "success",
            });
          } else {
            if (response.data && response.data.msg) {
              this.errorMsg.name = err.data.msg;
            } else {
              document.getElementById(this.modalDeleteId).close();
              this.$notify({
                title: "Notify",
                text: "Something went wrong, please try later.",
                type: "error",
              });
            }
          }
        })
        .catch((err) => {
          this.submiting = false;
          if (
            err.response.status == 422 &&
            err.response.data &&
            err.response.data.message
          ) {
            this.errorMsg.name = err.response.data.message;
          } else {
            document.getElementById(this.modalId).close();
            this.$notify({
              title: "Notify",
              text: "Something went wrong, please try later.",
              type: "error",
            });
          }
        });
    },
    handleCloseModal() {
      setTimeout(() => {
        this.selectedPermission = {
          name: "",
          description: "",
        };
      }, 500);
    },
    handleSubmitModal() {
      this.submiting = true;
      if (!this.selectedPermission.name) {
        this.errorMsg.name = "Please enter value";
        this.submiting = false;
        return;
      }
      this.errorMsg.name = "";
      this.submiting = true;
      this.$api
        .store(this.model, this.selectedPermission)
        .then((response) => {
          this.submiting = false;
          if (
            response.status == 200 &&
            response.data &&
            response.data.code == 0
          ) {
            document.getElementById(this.modalId).close();
            this.$notify({
              title: "Notify",
              text: "Success",
              type: "success",
            });
          } else {
            if (response.data && response.data.msg) {
              this.errorMsg.name = err.data.msg;
            } else {
              document.getElementById(this.modalId).close();
              this.$notify({
                title: "Notify",
                text: "Something went wrong, please try later.",
                type: "error",
              });
            }
          }
        })
        .catch((err) => {
          this.submiting = false;
          if (
            err.response.status == 422 &&
            err.response.data &&
            err.response.data.message
          ) {
            this.errorMsg.name = err.response.data.message;
          } else {
            document.getElementById(this.modalId).close();
            this.$notify({
              title: "Notify",
              text: "Something went wrong, please try later.",
              type: "error",
            });
          }
        });
    },
  },
}
