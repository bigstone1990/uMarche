<script setup>
const props = defineProps({
  filename: String
})
</script>

<template>
  <div>
    <img v-if="props.filename" :src="'/storage/shops/' + props.filename" alt="">
    <img v-else src="/images/no_image.jpg" alt="">
  </div>
</template>