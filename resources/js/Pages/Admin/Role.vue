<script setup>
import { onMounted, ref } from "vue";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Modal from "@/Components/Modal.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Input from "@/Components/Input.vue";
import InputError from "@/Components/InputError.vue";
</script>
<script>
import DataTable from "@/Mixins/datatable";

export default {
  mixins: [DataTable],
  data() {
    return {
      selectedRole: {
        name: "",
        description: "",
        default_redirect: "",
      },
      model: "role",
    };
  },
};
</script>
<template>
  <Head title="Role" />

  <AuthenticatedLayout>
    <template #header> Role </template>

    <DeleteModal
      @confirm="confirmDelete"
      @close="handleCloseModal"
      :modal-id="modalDeleteId"
      :title="'Delete Role'"
      :text-confirm="'Delete'"
      :textCancel="'Cancel'"
      :content="textDelete"
    ></DeleteModal>

    <Modal
      @close="handleCloseModal"
      @submit="handleSubmitModal"
      :submiting="submiting"
      :modal-id="modalId"
      :title="modalTitle"
      :text-confirm="modalTextConfirm"
      :text-cancel="modalTextCancel"
    >
      <div class="grid lg:grid-cols-2 md:grid-cols-1 gap-4">
        <div>
          <p class="mb-2 font-semibold text-gray-700">Name</p>
          <Input v-model="selectedRole.name" />
          <InputError :message="errorMsg.name"></InputError>
        </div>
        <div>
          <p class="mb-2 font-semibold text-gray-700">Description</p>
          <Input v-model="selectedRole.description" />
          <InputError :message="errorMsg.description"></InputError>
        </div>
      </div>
    </Modal>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-md">
          <!-- card header -->
          <div class="px-6 py-4 bg-white border-b border-gray-200 flex">
            <h3 class="font-bold uppercase">Role management</h3>
            <button @click="addItem" class="btn-add" title="">
              <img class="w-3 mt-2 mx-1" src="/imgs/plus-white.png" /> Add
            </button>
          </div>

          <!-- card body -->
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="my-2 flex sm:flex-row flex-col">
              <div class="flex flex-row mb-1 sm:mb-0">
                <div class="relative">
                  <select v-model="length" @change="initTable" class="select">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                    <option>100</option>
                  </select>
                </div>
              </div>
              <div class="block relative">
                <input
                  v-model="search"
                  @keyup="initTable"
                  placeholder="Search"
                  class="search"
                />
              </div>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
              <div
                class="inline-block min-w-full shadow rounded-lg overflow-hidden"
              >
                <table class="min-w-full leading-normal">
                  <thead>
                    <tr>
                      <th class="table-header">Action</th>
                      <th class="table-header">Role</th>
                      <th class="table-header">Description</th>
                      <th class="table-header">Created at</th>
                      <th class="table-header">Updated at</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in items" :key="item.id">
                      <td
                        class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex"
                      >
                        <button
                          @click="editItem(item)"
                          class="btn-edit"
                          title=""
                        >
                          <img class="w-3 mt-2 mx-1" src="/imgs/pencil.png" />
                          Edit
                        </button>
                        <button
                          @click="deleteItem(item)"
                          class="btn-delete"
                          title=""
                        >
                          <img class="w-3 mt-2 mx-1" src="/imgs/trash.png" />
                          Delete
                        </button>
                      </td>
                      <td
                        class="px-5 py-5 border-b border-gray-200 bg-white text-sm"
                      >
                        {{ item.name }}
                      </td>
                      <td
                        class="px-5 py-5 border-b border-gray-200 bg-white text-sm"
                      >
                        {{ item.description }}
                      </td>
                      <td
                        class="px-5 py-5 border-b border-gray-200 bg-white text-sm"
                      >
                        {{ item.created_at }}
                      </td>

                      <td
                        class="px-5 py-5 border-b border-gray-200 bg-white text-sm"
                      >
                        {{ item.updated_at }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div
                  class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between"
                >
                  <span class="text-xs xs:text-sm text-gray-900">
                    Showing {{ start + 1 }} to {{ start + filtered }} of
                    {{ total }} Entries
                  </span>
                  <div class="inline-flex mt-2 xs:mt-0">
                    <button class="btn-pagination">Prev</button>
                    <button class="btn-pagination">Next</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
