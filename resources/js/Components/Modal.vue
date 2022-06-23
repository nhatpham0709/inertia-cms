<script>
export default {
  props: {
    modalId: {
      type: String,
      default: "custom-modal",
    },
    title: {
      type: String,
      default: "",
    },
    textConfirm: {
      type: String,
      default: "Confirm",
    },
    textCancel: {
      type: String,
      default: "Cancel",
    },
    submiting: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    handleCloseModal() {
      document.getElementById(this.modalId).close();
    },
    handleSubmit() {
      if (!this.submiting) {
        this.$emit("submit");
      }
    },
  },
};
</script>

<template>
  <dialog :id="modalId" class="h-100 w-100 md:w-1/2 bg-white">
    <div
      class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg"
    >
      <p class="font-semibold text-gray-800">{{ title }}</p>
      <svg
        @click="handleCloseModal"
        class="w-6 h-6 cursor-pointer"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M6 18L18 6M6 6l12 12"
        ></path>
      </svg>
    </div>
    <div class="flex flex-col px-6 py-5 bg-gray-100">
      <slot></slot>
    </div>
    <div
      class="flex flex-row items-center justify-between p-5 bg-white border-t border-gray-200 rounded-bl-lg rounded-br-lg"
    >
      <p
        class="font-semibold text-gray-600 cursor-pointer"
        @click="handleCloseModal"
      >
        {{ textCancel }}
      </p>
      <button
        class="px-4 py-2 text-white font-semibold bg-blue-500 rounded flex disabled:opacity-70"
        :disabled="submiting"
        @click="handleSubmit"
      >
        <svg
          v-if="submiting"
          class="-ml-1 mr-3 h-5 w-5 animate-spin text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          ></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg>
        {{ textConfirm }}
      </button>
    </div>
  </dialog>
</template>
