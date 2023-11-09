<script setup>
import OwnersAuthenticatedLayout from '@/Layouts/OwnersAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Thumbnail from "@/Components/Thumbnail.vue";

const props = defineProps({
  errors: Object,
  image: Object,
})

const form = reactive({
  id: props.image.id,
  filename: props.image.filename,
  title: props.image.title,
})

const updateImage = (id) => {
    router.put(route('owner.images.update', {image: id}), form)
}

const deleteImage = (id) => {
    router.delete(route('owner.images.destroy', { image: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>

<template>
  <Head title="画像編集" />

  <OwnersAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">画像編集</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ValidationErrors v-bind:errors="props.errors"/>
            <form v-on:submit.prevent="updateImage(form.id)">
              <div class="container px-5 mx-auto">
                <div class="-m-2">
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="title" class="leading-7 text-sm text-gray-600">タイトル</label>
                      <input type="text" id="title" name="titel" v-model="form.title" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                  </div>
                  <div class="p-2 w-1/2 mx-auto">
                    <div class="relative">
                      <label for="thumbnail" class="leading-7 text-sm text-gray-600">画像</label>
                      <div class="w-32">
                        <Thumbnail v-bind:filename="form.filename" folder="products" />
                      </div>
                    </div>
                  </div>
                  <div class="p-2 w-full flex justify-center mt-4">
                    <button class="text-white bg-indigo-500 border-0 mx-4 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                    <button type="button" v-on:click="deleteImage(form.id)" class="text-white bg-red-400 border-0 mx-4 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</button>
                    <Link as="button" v-bind:href="route('owner.images.index')" class="bg-gray-200 border-0 mx-4 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</Link>
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
