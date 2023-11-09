<script setup>
import OwnersAuthenticatedLayout from '@/Layouts/OwnersAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Thumbnail from "@/Components/Thumbnail.vue";
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  shops: Array
})
</script>

<template>
    <Head title="店舗情報" />

    <OwnersAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">店舗情報</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <FlashMessage />
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                      <ul class="flex flex-wrap">
                        <li v-for="shop in props.shops" v-bind:key="shop.id" class="w-1/2 p-4">
                          <Link v-bind:href="route('owner.shops.edit', { shop: shop.id })">
                            <div class="border rounded-md p-4">
                              <div class="mb-4">
                                <span v-if="shop.is_selling" class="border p-2 rounded-md bg-blue-400 text-white">
                                  販売中
                                </span>
                                <span v-else class="border p-2 rounded-md bg-red-400 text-white">
                                  停止中
                                </span>
                              </div>
                              <div class="text-xl">
                                {{ shop.name }}
                              </div>
                              <Thumbnail v-bind:filename="shop.filename" folder="shops"/>
                            </div>
                          </Link>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </OwnersAuthenticatedLayout>
</template>
