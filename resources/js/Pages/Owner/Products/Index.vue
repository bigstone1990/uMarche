<script setup>
import OwnersAuthenticatedLayout from '@/Layouts/OwnersAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import Thumbnail from "@/Components/Thumbnail.vue";
import Pagination from '@/Components/Pagination.vue';
import { onMounted } from 'vue';

const props = defineProps({
  ownerInfo: Array
})

onMounted(
  () => {
    // console.log(props.ownerInfo[0].shop.product[0].image_first.filename)
    console.log(props.ownerInfo)
  }  
)

</script>

<template>
  <Head title="商品一覧" />

  <OwnersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品一覧</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <FlashMessage />
        <div class="flex pl-4 mb-4 lg:w-2/3 w-full mx-auto">
          <Link as="button" v-bind:href="route('owner.products.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">新規登録</Link>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ul v-if="props.ownerInfo[0].shop.product.length != 0" class="flex flex-wrap">
              <li v-for="product in props.ownerInfo[0].shop.product" v-bind:key="product.id" class="w-1/4 p-2 md:p-4">
                <Link v-bind:href="route('owner.products.edit', { product: product.id })">
                  <div class="border rounded-md p-2 md:p-4">
                    <Thumbnail v-bind:filename="(product.image_first || {}).filename" folder="products" />
                    <div class="text-gray-700">
                      {{ product.name }}
                    </div>
                  </div>
                </Link>
              </li>
            </ul>

            <!-- <ul v-if="props.ownerInfo.length != 0" class="flex flex-wrap">
              <li v-for="product in props.products" v-bind:key="product.id" class="w-1/4 p-2 md:p-4">
                <Link v-bind:href="route('owner.products.edit', { product: product.id })">
                  <div class="border rounded-md p-2 md:p-4">
                    {{ product.image1_filename }}
                    <Thumbnail v-bind:filename="product.image1_filename" folder="products" />
                    <div class="text-gray-700">
                      {{ product.name }}
                    </div>
                  </div>
                </Link>
              </li>
            </ul> -->
            <p v-else>商品データがありません。</p>
          </div>
          <!-- <Pagination class="mt-6" v-bind:links="props.images.links"></Pagination> -->
        </div>
      </div>
    </div>
  </OwnersAuthenticatedLayout>
</template>
