<script setup>
import OwnersAuthenticatedLayout from '@/Layouts/OwnersAuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Thumbnail from "@/Components/Thumbnail.vue";

const props = defineProps({
  errors: Object,
  shop: Object
})

const form = reactive({
  id: props.shop.id,
  name: props.shop.name,
  information: props.shop.information,
  filename: props.shop.filename,
  is_selling: props.shop.is_selling,
  file: null,
})

// const form = useForm({
//   id: props.shop.id,
//   file: null
// })

const updateShop = (id) => {
    router.post(route('owner.shops.update', { shop: id }), form)
}
</script>

<template>
    <Head title="Dashboard" />

    <OwnersAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                      <ValidationErrors v-bind:errors="props.errors"/>
                      <form v-on:submit.prevent="updateShop(form.id)" enctype="multipart/form-data">
                        <div class="container px-5 mx-auto">
                          <div class="-m-2">
                            <div class="p-2 w-1/2 mx-auto">
                              <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">店名 ※必須</label>
                                <input type="text" id="name" name="name" required v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                              <div class="relative">
                                <label for="information" class="leading-7 text-sm text-gray-600">店舗情報 ※必須</label>
                                <textarea id="information" name="information" rows="10" required v-model="form.information" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                              </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                              <div class="relative">
                                <label for="information" class="leading-7 text-sm text-gray-600">店舗画像</label>
                                <div class="w-32">
                                  <Thumbnail v-bind:filename="form.filename" folder="shops" />
                                </div>
                              </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                              <div class="relative">
                                <label for="image" class="leading-7 text-sm text-gray-600">画像更新</label>
                                <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/jpg" @input="form.file = $event.target.files[0]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                              <div class="relative flex justify-around">
                                <div>
                                  <input type="radio" name="is_selling" id="is_selling_true" v-model="form.is_selling" value="1"><label for="is_selling_true" class="leading-7 text-sm text-gray-600">販売中</label>
                                </div>
                                <div>
                                  <input type="radio" name="is_selling" id="is_selling_false" v-model="form.is_selling" value="0"><label for="is_selling_false" class="leading-7 text-sm text-gray-600">停止中</label>
                                </div>
                              </div>
                            </div>
                            <div class="p-2 w-full flex justify-around mt-4">
                              <Link as="button" v-bind:href="route('owner.shops.index')" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</Link>
                              <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </OwnersAuthenticatedLayout>
</template>
