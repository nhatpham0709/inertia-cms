<template>
  <div
    class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between"
  >
    <span class="text-xs xs:text-sm text-gray-900">
      Showing {{ start + 1 }} to {{ start + filtered }} of {{ total }} entries
    </span>
    <nav>
      <ul class="inline-flex mt-5">
        <li>
          <a class="btn-prev">Previous</a>
        </li>
        <li v-for="page in totalPages" :key="`page-${page}`">
          <a
            :class="
              page === currentPage ? 'btn-pagination-active' : 'btn-pagination'
            "
            @click="changePage(page)"
            >{{ page }}</a
          >
        </li>
        <li>
          <a class="btn-next">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

defineProps({
  start: Number,
  filtered: Number,
  total: Number,
  totalPages: {
    type: Number,
    required: false,
    default: 1,
  },
  currentPage: {
    type: Number,
    required: false,
    default: 1,
  },
});
const emit = defineEmits(['changePage']);
const changePage = (page) => {
  emit('changePage', page);
}

</script>
