<script setup>
const props = defineProps({
  filename: String,
  folder: String
})
</script>

<template>
  <div>
    <img v-if="props.filename" :src="'/storage/' + props.folder + '/' + props.filename" alt="">
    <img v-else src="/images/no_image.jpg" alt="">
  </div>
</template>