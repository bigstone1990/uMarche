<script setup></script>

<template>
  <div v-if="$page.props.flash.status === 'success'" class="bg-blue-300 text-white p-4 mb-4">
    {{ $page.props.flash.message }}
  </div>
  <div v-if="$page.props.flash.status === 'alert'" class="bg-red-500 text-white p-4 mb-4">
    {{ $page.props.flash.message }}
  </div>
</template>