export default {
  data() {
    return {
      items: [],
      search: "",
      meta: {
        total: 0,
        filtered: 0,
        start: 0,
        totalPages: 1,
        currentPage: 1,
        length: 10,
        order: "",
        order_by: "name",
        order_type: "desc",
      },

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
    async initTable() {
      try {
        const res = await this.$api.get(this.model, this.meta);
        this.items = res.data.data;
        this.meta.filtered = 10;
        this.meta.total = res.data.meta.pagination.total;
        this.meta.totalPages = res.data.meta.pagination.total_pages;
        this.meta.currentPage = res.data.meta.pagination.current_page;
      } catch (e) {

      }
    },
    changePage(page) {
      this.meta.currentPage = page;
      this.initTable();
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
        .then((res) => {
          this.submiting = false;
          if (
            res.status == 200 &&
            res.data &&
            res.data.code == 0
          ) {
            document.getElementById(this.modalDeleteId).close();
            this.$notify({
              title: "Notify",
              text: "Success",
              type: "success",
            });
          } else {
            if (res.data && res.data.msg) {
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
            err.res.status == 422 &&
            err.res.data &&
            err.res.data.message
          ) {
            this.errorMsg.name = err.res.data.message;
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
        .then((res) => {
          this.submiting = false;
          if (
            res.status == 200 &&
            res.data &&
            res.data.code == 0
          ) {
            document.getElementById(this.modalId).close();
            this.$notify({
              title: "Notify",
              text: "Success",
              type: "success",
            });
          } else {
            if (res.data && res.data.msg) {
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
            err.res.status == 422 &&
            err.res.data &&
            err.res.data.message
          ) {
            this.errorMsg.name = err.res.data.message;
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
