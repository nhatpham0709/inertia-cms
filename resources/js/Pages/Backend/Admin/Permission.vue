<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Modal from "@/Components/Modal.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Input from "@/Components/Input.vue";
import InputError from "@/Components/InputError.vue";
</script>
<script>
import DataTable from "@/Mixins/datatable"

export default {
  mixins: [DataTable],
  data() {
    return {
      selectedPermission: {
        name: "",
        description: "",
      },
      model: 'permission'
    };
  },
};
</script>

<template>
  <Head title="Permission" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permission
      </h2>
    </template>

    <DeleteModal
      @confirm="confirmDelete"
      @close="handleCloseModal"
      :modal-id="modalDeleteId"
      :title="'Delete Permission'"
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
          <Input v-model="selectedPermission.name" />
          <InputError :message="errorMsg.name"></InputError>
        </div>
        <div>
          <p class="mb-2 font-semibold text-gray-700">Description</p>
          <Input v-model="selectedPermission.description" />
          <InputError :message="errorMsg.description"></InputError>
        </div>
      </div>
    </Modal>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-md">
          <!-- card header -->
          <div class="px-6 py-4 bg-white border-b border-gray-200 flex">
            <h3 class="font-bold uppercase">Permission management</h3>
            <button
              @click="addItem "
              class="tracking-wider text-white bg-emerald-500 px-4 py-1 text-sm rounded leading-loose mx-2 ml-auto font-semibold flex"
              title=""
            >
              <img class="w-3 mt-2 mx-1" src="/imgs/plus-white.png" /> Add
            </button>
          </div>

          <!-- card body -->
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="my-2 flex sm:flex-row flex-col">
              <div class="flex flex-row mb-1 sm:mb-0">
                <div class="relative">
                  <select
                    v-model="length"
                    @change="initTablePermissions"
                    class="h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  >
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                  </select>
                </div>
              </div>
              <div class="block relative">
                <input
                  v-model="search"
                  @keyup="initTablePermissions"
                  placeholder="Search"
                  class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"
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
                      <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                      >
                        Action
                      </th>
                      <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                      >
                        Permission
                      </th>
                      <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                      >
                        Description
                      </th>
                      <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                      >
                        Created at
                      </th>
                      <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                      >
                        Updated at
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in items">
                      <td
                        class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex"
                      >
                        <button
                          @click="editItem(item)"
                          class="tracking-wider text-white bg-blue-400 px-4 py-1 text-sm rounded leading-loose mx-2 font-semibold flex"
                          title=""
                        >
                          <img class="w-3 mt-2 mx-1" src="/imgs/pencil.png" />
                          Edit
                        </button>
                        <button
                          @click="deleteItem(item)"
                          class="tracking-wider text-white bg-red-400 px-4 py-1 text-sm rounded leading-loose mx-2 font-semibold flex"
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
                    <button
                      class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l"
                    >
                      Prev
                    </button>
                    <button
                      class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r"
                    >
                      Next
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
