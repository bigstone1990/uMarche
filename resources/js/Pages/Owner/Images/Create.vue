<script setup>
import OwnersAuthenticatedLayout from '@/Layouts/OwnersAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import ValidationErrors from "@/Components/ValidationErrors.vue";

const props = defineProps({
  errors: Object,
})

const form = reactive({
  files: [],
})

const storeImage = () => {
    router.post(route('owner.images.store'), form)
}

const selectedFiles = (e) => {

  form.files = []

  for (let i = 0; i < e.target.files.length; i++)
  {
    form.files.push({image: e.target.files[i]})
  }

  // console.log(form.files)
}
</script>

<template>
  <Head title="画像アップロード" />

  <OwnersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">画像アップロード</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ValidationErrors v-bind:errors="props.errors"/>
            <form v-on:submit.prevent="storeImage" enctype="multipart/form-data">
              <div class="container px-5 mx-auto">
                <div class="-m-2">
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="image" class="leading-7 text-sm text-gray-600">画像更新</label>
                      <input type="file" id="image" name="files[][image]" multiple accept="image/png,image/jpeg,image/jpg" @input="selectedFiles" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                  </div>
                  <div class="p-2 w-full flex justify-around mt-4">
                    <Link as="button" v-bind:href="route('owner.images.index')" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</Link>
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
