<script setup>
import UsersAuthenticatedLayout from '@/Layouts/UsersAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Thumbnail from "@/Components/Thumbnail.vue";

const props = defineProps({
  products: Array,
})
</script>

<template>
  <Head title="商品一覧" />

  <UsersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">ホーム</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ul v-if="props.products.length != 0" class="flex flex-wrap">
              <li v-for="product in props.products" v-bind:key="product.id" class="w-1/4 p-2 md:p-4">
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
          </div>
        </div>
      </div>
    </div>
  </UsersAuthenticatedLayout>
</template>
