<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import dayjs from 'dayjs'
import { formatDistanceToNowStrict, parseISO } from 'date-fns'
import jaLocale from 'date-fns/locale/ja'
import FlashMessage from '@/Components/FlashMessage.vue';
import Pagination from '@/Components/Pagination.vue';
// import { getTodayDateTime } from '@/common'
// import { computed } from 'vue';
// defineProps({
  //   e_all: Array,
  //   q_get: Array
  // })

defineProps({
  owners: Object
})

// const todayDateTime = computed(
//   () => {
//     return getTodayDateTime()
//   }
// )

const deleteOwner = (id) => {
    router.delete(route('admin.owners.destroy', { owner: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>

<template>
  <Head title="オーナー一覧" />

  <AdminAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">オーナー一覧</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="md:p-6 text-gray-900">
            <!-- <ul v-for="owner in owners" v-bind:key="owner.id">
              <li>{{ owner.name }}</li>
              <li>{{ owner.email }}</li>
              <li>{{ dayjs(owner.created_at).format('YYYY-MM-DD HH:mm:ss') }}</li>
              <li>{{ formatDistanceToNowStrict(parseISO(owner.created_at), { addSuffix: true, locale: jaLocale, roundingMethod: 'floor'}) }}</li>
            </ul> -->
            <section class="text-gray-600 body-font">
              <div class="container md:px-5 mx-auto">
                <FlashMessage />
                <div class="flex pl-4 mb-4 lg:w-2/3 w-full mx-auto">
                  <Link as="button" v-bind:href="route('admin.owners.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">新規登録</Link>
                </div>
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                  <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                      <tr>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">オーナー名</th>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">作成日</th>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="owner in owners.data" v-bind:key="owner.id">
                        <td class="md:px-4 py-3">{{ owner.name }}</td>
                        <td class="md:px-4 py-3">{{ owner.email }}</td>
                        <td class="md:px-4 py-3">{{ formatDistanceToNowStrict(parseISO(owner.created_at), { addSuffix: true, locale: jaLocale, roundingMethod: 'floor'}) }}</td>
                        <td class="md:px-4 py-3">
                          <Link as="button" v-bind:href="route('admin.owners.edit', { owner: owner.id })" class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-500 rounded">編集</Link>
                        </td>
                        <td class="md:px-4 py-3">
                          <button v-on:click="deleteOwner(owner.id)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <Pagination class="mt-6" v-bind:links="owners.links"></Pagination>
              </div>
            </section>
          </div>
          <!-- <div class="p-6 text-gray-900">
            Eloquent
            <ul>
              <li v-for="e_owner in e_all" v-bind:key="e_owner.id">{{ e_owner.name }} {{ dayjs(e_owner.created_at).format('YYYY-MM-DD HH:mm:ss') }}</li>
            </ul>
            Querybuilder
            <ul>
              <li v-for="q_owner in q_get" v-bind:key="q_owner.id">{{ q_owner.name }} {{ dayjs(q_owner.created_at).format('YYYY-MM-DD HH:mm:ss') }}</li>
            </ul>
          </div> -->
        </div>
      </div>
    </div>
  </AdminAuthenticatedLayout>
</template>
