<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from "vue"
import ValidationErrors from "@/Components/ValidationErrors.vue";
import { onBeforeUpdate } from 'vue';
import { onUpdated } from 'vue';

defineProps({
    errors: Object
})

const form = reactive({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
})

const storeOwner = () => {
  router.post('/admin/owners', form)
}

onBeforeUpdate(
  () => {
    form.password = null
    form.password_confirmation = null
    // console.log('beforeUpdate called')
  }
)
</script>

<template>
  <Head title="オーナー登録" />

  <AdminAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">オーナー登録</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font relative">
              <ValidationErrors v-bind:errors="errors"/>
              <form v-on:submit.prevent="storeOwner">
                <div class="container px-5 mx-auto">
                  <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="-m-2">
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="name" class="leading-7 text-sm text-gray-600">オーナー名</label>
                          <input type="text" id="name" name="name" required v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                          <input type="email" id="email" name="email" required v-model="form.email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                          <input type="password" id="password" name="password" required v-model="form.password" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="password_confirmation" class="leading-7 text-sm text-gray-600">メールアドレス確認</label>
                          <input type="password" id="password_confirmation" name="password_confirmation" required v-model="form.password_confirmation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                      </div>
                      <div class="p-2 w-full flex justify-around mt-4">
                        <Link as="button" v-bind:href="route('admin.owners.index')" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</Link>
                        <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                      </div>
                    </div>
                  </div>
                </div>              
              </form>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AdminAuthenticatedLayout>
</template>
