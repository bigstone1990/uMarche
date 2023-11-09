<script setup>
import OwnersAuthenticatedLayout from '@/Layouts/OwnersAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import Thumbnail from "@/Components/Thumbnail.vue";
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
  images: Object
})

</script>

<template>
  <Head title="画像一覧" />

  <OwnersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">画像一覧</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <FlashMessage />
        <div class="flex pl-4 mb-4 lg:w-2/3 w-full mx-auto">
          <Link as="button" v-bind:href="route('owner.images.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">新規登録</Link>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ul v-if="props.images.data.length != 0" class="flex flex-wrap">
              <li v-for="image in props.images.data" v-bind:key="image.id" class="w-1/4 p-2 md:p-4">
                <Link v-bind:href="route('owner.images.edit', { image: image.id })">
                  <div class="border rounded-md p-2 md:p-4">
                    <Thumbnail v-bind:filename="image.filename" folder="products" />
                    <div class="text-gray-700">
                      {{ image.title }}
                    </div>
                  </div>
                </Link>
              </li>
            </ul>
            <p v-else>画像データがありません。</p>
          </div>
          <Pagination class="mt-6" v-bind:links="props.images.links"></Pagination>
        </div>
      </div>
    </div>
  </OwnersAuthenticatedLayout>
</template>
