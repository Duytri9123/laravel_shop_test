<template>
  <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <!-- tips -->
    <el-dialog
      v-model="dialogVisible"
      :title="editMode ? 'Edit Product' : 'Add Product'"
      width="45%"
    >
      <!-- form add -->
      <section class="bg-white dark:bg-gray-900">
        <div class="px-4 mx-auto max-w-2xl lg:py-1">
          <form @submit.prevent="editMode ? updateProduct() : AddProduct()">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div class="sm:col-span-2">
                <label
                  for="floating_title"
                  class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                  >Title</label
                >
                <input
                  v-model="title"
                  type="text"
                  name="floating_title"
                  id="floating_title"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder=""
                  required=""
                />
              </div>
              <div class="w-full">
                <label
                  for="brand"
                  class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                  >Brand</label
                >
                <select
                  v-model="brand_id"
                  id="brand"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                >
                  <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                    {{ brand.name }}
                  </option>
                </select>
              </div>
              <div class="w-full">
                <label
                  for="price"
                  class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                  >Price</label
                >
                <input
                  v-model="price"
                  type="number"
                  name="price"
                  id="price"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder=""
                  required=""
                />
              </div>
              <div>
                <label
                  for="category"
                  class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                  >Category</label
                >
                <select
                  v-model="category_id"
                  id="category"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                >
                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
              <div>
                <label
                  for="Quantity"
                  class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                  >Quantity</label
                >
                <input
                  v-model="quantity"
                  type="number"
                  name="Quantity"
                  id="Quantity"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder=""
                  required=""
                />
              </div>
              <div class="sm:col-span-2">
                <label
                  for="description"
                  class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                  >Description</label
                >
                <textarea
                  v-model="description"
                  id="description"
                  rows="8"
                  class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder="Your description here"
                ></textarea>
              </div>
            </div>

            <!-- multiple images upload -->
            <div class="sm:col-span-2 mt-2">
              <el-form-item label="Image:">
                <el-upload
                  v-model:file-list="productImages"
                  list-type="picture-card"
                  multiple
                  :on-preview="handlePictureCardPreview"
                  :on-remove="handleRemove"
                  :on-change="handleFileChange"
                  :auto-upload="false"
                >
                  <el-icon><Plus /></el-icon>
                </el-upload>
              </el-form-item>

              <el-dialog v-model="filePreviewVisible">
                <img :src="dialogImageUrl" alt="Preview" class="w-full" />
              </el-dialog>
            </div>
            <!-- end -->

            <!-- list of images for selected product -->

            <div class="grid grid-cols-4 gap-2 mt-2">
              <div
                v-for="(img_thumnail, index) in product_images"
                :key="img_thumnail"
                class="border rounded relative"
              >
                <img :src="`/${img_thumnail.image}`" class="object-cover w-full h-26" />
                <span
                  class="absolute top-0 right-0 transform -translate-y-2.5 w-5 h-5 bg-red-400 border-2 border-white dark:border-gray-800 rounded-full"
                >
                  <span
                    @click="deleteImage(img_thumnail, index)"
                    class="text-white text-xm font-bold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                  >
                    x</span
                  >
                </span>
              </div>
            </div>
            <button
              type="submit"
              class="inline-flex items-center px-5 py-1 mt-2 sm:mt-6 sm:text-sm font-medium text-center text-gray-900 bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800"
            >
              {{ isAddProduct ? "Add Product" : "Submit" }}
            </button>
          </form>
        </div>
      </section>
    </el-dialog>

    <!-- end -->

    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
      <!-- Start coding here -->
      <div
        class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden"
      >
        <div
          class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4"
        >
          <div class="w-full md:w-1/2">
            <form class="flex items-center">
              <label for="simple-search" class="sr-only">Search</label>
              <div class="relative w-full">
                <div
                  class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                >
                  <svg
                    aria-hidden="true"
                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                    fill="currentColor"
                    viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <input
                  type="text"
                  id="simple-search"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder="Search"
                  required=""
                />
              </div>
            </form>
          </div>
          <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
          >
            <button
              type="button"
              @click="openAddModal"
              class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
            >
              <svg
                class="h-3.5 w-3.5 mr-2"
                fill="currentColor"
                viewbox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
              >
                <path
                  clip-rule="evenodd"
                  fill-rule="evenodd"
                  d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                />
              </svg>
              Add product
            </button>
            <div class="flex items-center space-x-3 w-full md:w-auto">
              <button
                id="actionsDropdownButton"
                data-dropdown-toggle="actionsDropdown"
                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                type="button"
              >
                <svg
                  class="-ml-1 mr-1.5 w-5 h-5"
                  fill="currentColor"
                  viewbox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    clip-rule="evenodd"
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  />
                </svg>
                Actions
              </button>
              <div
                id="actionsDropdown"
                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
              >
                <ul
                  class="py-1 text-sm text-gray-700 dark:text-gray-200"
                  aria-labelledby="actionsDropdownButton"
                >
                  <li>
                    <a
                      href="#"
                      class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                      >Mass Edit</a
                    >
                  </li>
                </ul>
                <div class="py-1">
                  <a
                    href="#"
                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                    >Delete all</a
                  >
                </div>
              </div>
              <button
                id="filterDropdownButton"
                data-dropdown-toggle="filterDropdown"
                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                type="button"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                  class="h-4 w-4 mr-2 text-gray-400"
                  viewbox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                    clip-rule="evenodd"
                  />
                </svg>
                Filter
                <svg
                  class="-mr-1 ml-1.5 w-5 h-5"
                  fill="currentColor"
                  viewbox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    clip-rule="evenodd"
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  />
                </svg>
              </button>
              <div
                id="filterDropdown"
                class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700"
              >
                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                  Choose brand
                </h6>
                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                  <li class="flex items-center">
                    <input
                      id="apple"
                      type="checkbox"
                      value=""
                      class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    />
                    <label
                      for="apple"
                      class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                      >Apple (56)</label
                    >
                  </li>
                  <li class="flex items-center">
                    <input
                      id="fitbit"
                      type="checkbox"
                      value=""
                      class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    />
                    <label
                      for="fitbit"
                      class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                      >Microsoft (16)</label
                    >
                  </li>
                  <li class="flex items-center">
                    <input
                      id="razor"
                      type="checkbox"
                      value=""
                      class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    />
                    <label
                      for="razor"
                      class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                      >Razor (49)</label
                    >
                  </li>
                  <li class="flex items-center">
                    <input
                      id="nikon"
                      type="checkbox"
                      value=""
                      class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    />
                    <label
                      for="nikon"
                      class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                      >Nikon (12)</label
                    >
                  </li>
                  <li class="flex items-center">
                    <input
                      id="benq"
                      type="checkbox"
                      value=""
                      class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    />
                    <label
                      for="benq"
                      class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                      >BenQ (74)</label
                    >
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-4 py-3">Product name</th>
                <th scope="col" class="px-4 py-3">Category</th>
                <th scope="col" class="px-4 py-3">Brand</th>
                <th scope="col" class="px-4 py-3">Quantity</th>
                <th scope="col" class="px-4 py-3">Stock</th>
                <th scope="col" class="px-4 py-3">published</th>
                <th scope="col" class="px-4 py-3">Price</th>
                <th scope="col" class="px-4 py-3">
                  <span class="sr-only">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="product in products"
                :key="product.id"
                class="border-b dark:border-gray-700"
              >
                <th
                  scope="row"
                  class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ product.title }}
                </th>
                <td class="px-4 py-3">{{ product.category.name }}</td>
                <td class="px-4 py-3">{{ product.brand.name }}</td>
                <td class="px-4 py-3">{{ product.quantity }}</td>
                <td class="px-4 py-3">
                  <span
                    v-if="product.instock == 0"
                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300"
                    >InStock</span
                  >
                  <span
                    v-else
                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"
                    >OutStock</span
                  >
                </td>

                <td class="px-4 py-3">
                  <button
                    type="button"
                    v-if="product.published == 0"
                    class="px-3 py-2 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                  >
                    Published
                  </button>
                  <button
                    type="button"
                    v-else
                    class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                  >
                    UnPublished
                  </button>
                </td>
                <td class="px-4 py-3">{{ product.price }}</td>

                <td class="px-4 py-3 flex items-center justify-end">
                  <button
                    :id="`${product.id}-button`"
                    :data-dropdown-toggle="`${product.id}}`"
                    class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                    type="button"
                  >
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewbox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                      />
                    </svg>
                  </button>

                  <!-- show dropdow -->
                  <div
                    :id="`${product.id}}`"
                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                  >
                    <ul
                      class="py-1 text-sm text-gray-700 dark:text-gray-200"
                      :aria-labelledby="`${product.id}-button`"
                    >
                      <li>
                        <a
                          href="#"
                          class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                          >Show</a
                        >
                      </li>
                      <li>
                        <button
                          @click="openEditModal(product)"
                          class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                          Edit
                        </button>
                      </li>
                    </ul>
                    <div class="py-1">
                      <a
                        href="#"
                        @click="deleteProduct(product, index)"
                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                        >Delete</a
                      >
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- phan trang -->
        <nav
          class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
          aria-label="Table navigation"
        >
          <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Showing
            <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
            of
            <span class="font-semibold text-gray-900 dark:text-white">1000</span>
          </span>
          <ul class="inline-flex items-stretch -space-x-px">
            <li>
              <a
                href="#"
                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
              >
                <span class="sr-only">Previous</span>
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="currentColor"
                  viewbox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
            </li>
            <li>
              <a
                href="#"
                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >1</a
              >
            </li>
            <li>
              <a
                href="#"
                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >2</a
              >
            </li>
            <li>
              <a
                href="#"
                aria-current="page"
                class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                >3</a
              >
            </li>
            <li>
              <a
                href="#"
                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >...</a
              >
            </li>
            <li>
              <a
                href="#"
                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >100</a
              >
            </li>
            <li>
              <a
                href="#"
                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
              >
                <span class="sr-only">Next</span>
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="currentColor"
                  viewbox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
</template>

<script setup>
import { usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Plus } from "@element-plus/icons-vue";
import Swal from "sweetalert2";

defineProps({
  products: Array,
});
const brands = usePage().props.brands;
const categories = usePage().props.categories;

const isAddProduct = ref(false);
const dialogVisible = ref(false);
const editMode = ref(false);

// upload mulitpel images
const productImages = ref([]);
const dialogImageUrl = ref("");
const filePreviewVisible = ref(false);
//product from data
const id = ref(null);
const title = ref("");
const price = ref("");
const quantity = ref("");
const description = ref("");
const product_images = ref([]);
const published = ref("");
const category_id = ref("");
const brand_id = ref("");
const instock = ref("");

const handlePictureCardPreview = (file) => {
  dialogImageUrl.value = file.url;
  filePreviewVisible.value = true;
};

const handleFileChange = (file) => {
  productImages.value.push(file);
};

const handleRemove = (file) => {
  console.log(file);
};

//reset form data
const resetFormData = () => {
  (id.value = ""),
    (title.value = ""),
    (price.value = ""),
    (quantity.value = ""),
    (description.value = ""),
    (productImages.value = []);
  dialogImageUrl.value = "";
};

// add product method
const AddProduct = async () => {
  const formData = new FormData();
  formData.append("title", title.value);
  formData.append("price", price.value);
  formData.append("quantity", quantity.value);
  formData.append("description", description.value);
  formData.append("category_id", category_id.value);
  formData.append("brand_id", brand_id.value);

  //append product images to the form data

  for (const image of productImages.value) {
    formData.append("product_images[]", image.raw);
  }

  try {
    router.post("products/store", formData, {
      onSuccess: (page) => {
        Swal.fire({
          toast: true,
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          title: page.props.flash.success,
        });
        dialogVisible.value = false;
        resetFormData();
      },
    });
  } catch (err) {
    console.log(err);
  }
};

//open Add Model
const openAddModal = () => {
  isAddProduct.value = true;
  dialogVisible.value = true;
  editMode.value = false;
};
const openEditModal = (product) => {
  editMode.value = true;
  isAddProduct.value = false;
  dialogVisible.value = true;

  //update data
  (id.value = product.id),
    (title.value = product.title),
    (price.value = product.price),
    (quantity.value = product.quantity),
    (description.value = product.description),
    (brand_id.value = product.brand_id),
    (category_id.value = product.category_id),
    (product_images.value = product.product_images);
};
//delete sigal product image
const deleteImage = async (img_thumnail, index) => {
  try {
    await router.delete("/admin/products/image/" + img_thumnail.id, {
      onSuccess: (page) => {
        product_images.value.splice(index, 1);
        Swal.fire({
          toast: true,
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          title: page.props.flash.success,
        });
      },
    });
  } catch (err) {
    console.log(err);
  }
};
// update product method

const updateProduct = async () => {
  const formData = new FormData();
  formData.append("title", title.value);
  formData.append("price", price.value);
  formData.append("quantity", quantity.value);
  formData.append("description", description.value);
  formData.append("category_id", category_id.value);
  formData.append("brand_id", brand_id.value);
  formData.append("_method", "PUT");
  //append product images to the form data

  for (const image of productImages.value) {
    formData.append("product_images[]", image.raw);
  }

  try {
    router.post("products/update/" + id.value, formData, {
      onSuccess: (page) => {
        Swal.fire({
          toast: true,
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          title: page.props.flash.success,
        });
        dialogVisible.value = false;
        resetFormData();
      },
    });
  } catch (err) {
    console.log(err);
  }
};
//delete product
const deleteProduct = (product, index) => {
  Swal.fire({
    title: "Are you Sure",
    text: "This actions cannot undo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "no",
    confirmButtonText: "yes, delete!",
  }).then((result) => {
    if (result.isConfirmed) {
      try {
        router.delete("products/destory/" + product.id, {
          onSuccess: (page) => {
            this.delete(product, index);
            Swal.fire({
              toast: true,
              icon: "success",
              position: "top-end",
              showConfirmButton: false,
              title: page.props.flash.success,
            });
          },
        });
      } catch (err) {
        console.log(err);
      }
    }
  });
};
</script>
