<script setup>
import UsersAuthenticatedLayout from '@/Layouts/UsersAuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  products: Object,
  totalPrice: Number,
})

const deleteCart = (id) => {
    router.delete(route('user.cart.delete', { item: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>

<template>
  <Head title="カート" />

  <UsersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">カート</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <FlashMessage />
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div v-if="props.products.length > 0">
              <div v-for="product in props.products" v-bind:key="product.id" class="md:flex md:items-center mb-2">
                <div class="md:w-3/12 md:ml-3">
                  <img v-if="product.image_first.filename" :src="'/storage/products/' + product.image_first.filename" alt="">
                  <img v-else src="/images/no_image.jpg" alt="">
                </div>
                <div class="md:w-4/12 md:ml-3">{{ product.name }}</div>
                <div class="md:w-3/12 flex justify-around">
                  <div>{{ product.pivot.quantity }}個</div>
                  <div>{{ (product.pivot.quantity * product.price).toLocaleString() }}円(税込)</div>
                </div>
                <div class="md:w-2/12">
                  <button type="button" v-on:click="deleteCart(product.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="my-2">
                小計: {{ props.totalPrice.toLocaleString() }}<span class="text-sm text-gray-700">円(税込)</span>
              </div>
              <div>
                <Link as="button" v-bind:href="route('user.cart.checkout')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">購入する</Link>
              </div>
            </div>
            <div v-else>カートに商品が入っていません。</div>
          </div>
        </div>
      </div>
    </div>
  </UsersAuthenticatedLayout>
</template>
