<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { formatDistanceToNowStrict, parseISO } from 'date-fns'
import jaLocale from 'date-fns/locale/ja'
import FlashMessage from '@/Components/FlashMessage.vue';

defineProps({
  expiredOwners: Array
})

const deleteOwner = (id) => {
    router.delete(route('admin.expired-owners.destroy', { owner: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>

<template>
  <Head title="期限切れオーナー一覧" />

  <AdminAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">期限切れオーナー一覧</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font">
              <div class="container px-5 mx-auto">
                <FlashMessage />
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                  <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                      <tr>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">オーナー名</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">期限切れ日</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="owner in expiredOwners" v-bind:key="owner.id">
                        <td class="px-4 py-3">{{ owner.name }}</td>
                        <td class="px-4 py-3">{{ owner.email }}</td>
                        <td class="px-4 py-3">{{ formatDistanceToNowStrict(parseISO(owner.deleted_at), { addSuffix: true, locale: jaLocale, roundingMethod: 'floor'}) }}</td>
                        <td class="px-4 py-3">
                          <button v-on:click="deleteOwner(owner.id)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">完全削除</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AdminAuthenticatedLayout>
</template>
