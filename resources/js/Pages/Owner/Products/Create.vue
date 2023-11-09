<script setup>
import OwnersAuthenticatedLayout from '@/Layouts/OwnersAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Thumbnail from "@/Components/Thumbnail.vue";
import { onMounted } from 'vue';
import MicroModal from '@/Components/MicroModal.vue';

const props = defineProps({
  errors: Object,
  shops: Array,
  images: Array,
  categories: Array,
})

onMounted(
  () => {
    // console.log(props)
  }
)

const form = reactive({
  name: null,
  information: null,
  price: null,
  sort_order: null,
  quantity: null,
  shop_id: null,
  category: null,
  image1: null,
  image2: null,
  image3: null,
  image4: null,
  is_selling: 1,
})

const updateImageValue = (
  (e) => {
    console.log(e)
    form.image1 = e
  }
)

const storeProduct = () => {
    router.post(route('owner.products.store'), form)
}
</script>

<template>
  <Head title="商品登録" />

  <OwnersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品登録</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ValidationErrors v-bind:errors="props.errors"/>
            <form v-on:submit.prevent="storeProduct">
              <div class="container px-5 mx-auto">
                <div class="-m-2">
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                      <input type="text" id="name" name="name" required v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                  </div>
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                      <textarea id="information" name="information" rows="10" required v-model="form.information" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                  </div>
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                      <input type="number" id="price" name="price" required v-model="form.price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                  </div>
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                      <input type="number" id="sort_order" name="sort_order" v-model="form.sort_order" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                  </div>
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫 ※必須</label>
                      <input type="number" id="quantity" name="quantity" required v-model="form.quantity" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      <span class="text-sm">0~99の範囲で入力してください。</span>
                    </div>
                  </div>
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗</label>
                      <select name="shop_id" id="shop_id" v-model="form.shop_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <option v-for="shop in props.shops" v-bind:key="shop.id" v-bind:value="shop.id">
                          {{ shop.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="category" class="leading-7 text-sm text-gray-600">カテゴリ</label>
                      <select name="category" id="category" v-model="form.category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <optgroup v-for="category in categories" v-bind:key="category.id" v-bind:label="category.name">
                          <option v-for="secondary in category.secondary" v-bind:value="secondary.id">
                            {{ secondary.name }}
                          </option>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                  <MicroModal name="image1" v-bind:images="images" @update:imageValue="((e) => {form.image1 = Number(e)})" />
                  <MicroModal name="image2" v-bind:images="images" @update:imageValue="((e) => {form.image2 = Number(e)})" />
                  <MicroModal name="image3" v-bind:images="images" @update:imageValue="((e) => {form.image3 = Number(e)})" />
                  <MicroModal name="image4" v-bind:images="images" @update:imageValue="((e) => {form.image4 = Number(e)})" />
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
                    <Link as="button" v-bind:href="route('owner.products.index')" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</Link>
                    <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
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
