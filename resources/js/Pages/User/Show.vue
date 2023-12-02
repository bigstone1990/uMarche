<script setup>
import UsersAuthenticatedLayout from '@/Layouts/UsersAuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Swiper from "@/Components/Swiper.vue";
import { ref, reactive } from "vue"

const props = defineProps({
  product: Object,
  quantity: String,
})

const form = reactive({
  product_id: props.product.id,
  quantity: 1,
})

const images = []

if (props.product.image_first != null){
  images.push({filename: props.product.image_first.filename})
}

if (props.product.image_second != null){
  images.push({filename: props.product.image_second.filename})
}

if (props.product.image_third != null){
  images.push({filename: props.product.image_third.filename})
}

if (props.product.image_fourth != null){
  images.push({filename: props.product.image_fourth.filename})
}

// console.log(images)

const isShow = ref(false)

const toggleStatus = (
  () => {
    isShow.value = !isShow.value
  }
) 

const addCart = () => {
    router.post(route('user.cart.add'), form)
}
</script>

<template>
  <Head title="商品の詳細" />

  <UsersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品の詳細</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="md:flex md:justify-around">
              <div class="md:w-1/2">
                <Swiper v-bind:images="images"/>
                <!-- <Thumbnail v-bind:filename="(props.product.image_first || {}).filename" folder="products" /> -->
              </div>
              <div class="md:w-1/2 ml-4">
                <form v-on:submit.prevent="addCart">
                  <h2 class="mb-4 text-sm title-font text-gray-500 tracking-widest">{{ (props.product.category || {}).name }}</h2>
                  <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium">{{ props.product.name }}</h1>
                  <p class="mb-4 leading-relaxed">{{ props.product.information }}</p>
                  <div class="flex items-center mb-4">
                    <div>
                      <span class="title-font font-medium text-2xl text-gray-900">{{ props.product.price.toLocaleString() }}<span class="text-sm text-gray-700">円(税込)</span></span>
                    </div>
                    <div class="flex ml-6 items-center">
                      <span class="mr-3">数量</span>
                      <div class="relative">
                        <select v-model="form.quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                          <option v-for="quantity in Number(props.quantity)" v-bind:key="quantity" v-bind:value="quantity">{{ quantity }}</option>
                        </select>
                        <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                            <path d="M6 9l6 6 6-6"></path>
                          </svg>
                        </span>
                      </div>
                    </div>
                  </div>
                  <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                </form>
              </div>
            </div>
            <div class="border-t border-gray-400 my-8"></div>
            <div class="mb-4 text-center">この商品を販売しているショップ</div>
            <div class="mb-4 text-center">{{ props.product.shop.name }}</div>
            <div class="mb-4 text-center">
              <img v-if="props.product.shop.filename" :src="'/storage/shops/'+ props.product.shop.filename" class="mx-auto object-cover w-40 h-40 rounded-full" alt="">
              <img v-else src="/images/no_image.jpg" class="mx-auto object-cover w-40 h-40 rounded-full" alt="">
            </div>
            <div class="mb-4 text-center">
              <button v-on:click="toggleStatus" type="button" class="text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded" href='javascript:;'>ショップの詳細を見る</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
    <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
        <header class="modal__header">
          <h2 class="text-xl text-gray-700" id="modal-1-title">
            {{ props.product.shop.name }}
          </h2>
          <button v-on:click="toggleStatus" type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" id="modal-1-content">
          <p>
            {{ props.product.shop.information }}
          </p>
        </main>
        <footer class="modal__footer">
          <button v-on:click="toggleStatus" type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
        </footer>
      </div>
    </div>
  </div>
  </UsersAuthenticatedLayout>
</template>
