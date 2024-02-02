<script setup>
import UsersAuthenticatedLayout from '@/Layouts/UsersAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Thumbnail from "@/Components/Thumbnail.vue";
import { ref, reactive } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
  products: Object,
  sort: String,
  pagination: String,
  constants: Object,
  categories: Array,
  category: String,
  keyword: String,
})

const form = reactive({
  sort: props.sort,
  pagination: props.pagination,
  category: props.category,
  keyword: props.keyword,
})

const search = reactive({
  category: props.category,
  keyword: props.keyword,
})

const sortItems = () => {
    router.get(route('user.items.index'), form)
    // console.log(form.sort_order)
}

const searchItems = () => {
    router.get(route('user.items.index'), search)
}
</script>

<template>
  <Head title="商品一覧" />

  <UsersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">商品一覧</h2>
      <div class="lg:flex lg:justify-around">
        <form v-on:submit.prevent="searchItems" class="lg:flex lg:items-end lg:space-x-2">
          <select v-model="search.category" class="mb-2 lg:mb-0">
            <option value="0">すべて</option>
            <optgroup v-for="category in categories" v-bind:key="category.id" v-bind:label="category.name">
              <option v-for="secondary in category.secondary" v-bind:value="secondary.id">
                {{ secondary.name }}
              </option>
            </optgroup>
          </select>
          <div class="flex items-center space-x-2">
            <div><input v-model="search.keyword" type="text" class="border border-gray-500 py-2" placeholder="キーワードを入力"></div>
            <button class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">検索する</button>
          </div>
        </form>
        <div class="flex mt-2 lg:mt-0">
          <div>
            <span class="text-sm">表示順</span><br>
            <select v-on:change="sortItems" v-model="form.sort" class="mr-4">
              <option v-bind:value="props.constants.recommend">おすすめ順</option>
              <option v-bind:value="props.constants.higherPrice">料金の高い順</option>
              <option v-bind:value="props.constants.lowerPrice">料金の低い順</option>
              <option v-bind:value="props.constants.later">新しい順</option>
              <option v-bind:value="props.constants.older">古い順</option>
            </select>
          </div>
          <div>
            <span class="text-sm">表示件数</span><br>
            <select v-on:change="sortItems" v-model="form.pagination" class="mr-4">
              <option value="8">8件</option>
              <option value="16">16件</option>
              <option value="32">32件</option>
            </select>
          </div>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ul v-if="props.products.total != 0" class="flex flex-wrap">
              <li v-for="product in props.products.data" v-bind:key="product.id" class="w-1/4 p-2 md:p-4">
                <Link v-bind:href="route('user.items.show', { item: product.id })">
                  <div class="border rounded-md p-2 md:p-4">
                    <Thumbnail v-bind:filename="product.filename" folder="products" />
                    <div class="mt-4">
                      <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ product.category }}</h3>
                      <h2 class="text-gray-900 title-font text-lg font-medium">{{ product.name }}</h2>
                      <p class="mt-1">{{ product.price.toLocaleString() }}<span class="text-sm text-gray-700">円(税込)</span></p>
                    </div>
                  </div>
                </Link>
              </li>
            </ul>
            <p v-else>商品データがありません。</p>
            <Pagination class="mt-6" v-bind:links="props.products.links" v-bind:form="form"></Pagination>
          </div>
        </div>
      </div>
    </div>
  </UsersAuthenticatedLayout>
</template>
