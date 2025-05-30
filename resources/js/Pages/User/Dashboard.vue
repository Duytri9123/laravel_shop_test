<template>
  <UserLayouts>
    <div class="relative mx-auto max-w-screen-xl mt-10 overflow-x-auto">
      <table
        v-show="order.order_items.length > 0"
        v-for="order in orders"
        :key="order.id"
        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-5"
      >
        <thead
          class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 grid"
        >
          <tr>
            <th scope="col" class="px-6 py-3 text-red-400">Order ID # {{ order.id }}</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in order.order_items"
            :key="item.id"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
          >
            <th
              scope="row"
              class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{item.product.title}}
            </th>
            <td class="px-6 py-4">{{ item.product.brand.name }}</td>
            <td class="px-6 py-4">{{ item.product.category.name }}</td>
            <td class="px-6 py-4">{{item.product.price}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </UserLayouts>
</template>

<script setup>
import { initFlowbite } from "flowbite";
import UserLayouts from "./Layouts/UserLayouts.vue";
import { onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

defineProps({
  orders: Array,
});
onMounted(() => {
  initFlowbite();
});
</script>

<style lang="scss" scoped></style>
