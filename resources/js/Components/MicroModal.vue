<script setup>
import { onMounted } from 'vue';
import { ref } from 'vue';

const props = defineProps({
  name: String,
  images: Array,
  currentId: Number,
  currentImage: String,
})

const emit = defineEmits(['update:imageValue'])

const modal = ref("")

onMounted(
  () => {
    if (props.name === 'image1') {
      modal.value = 'modal-1'
    }
    else if (props.name === 'image2') {
      modal.value = 'modal-2'
    }
    else if (props.name === 'image3') {
      modal.value = 'modal-3'
    }
    else if (props.name === 'image4') {
      modal.value = 'modal-4'
    }

    if (props.currentImage) {
      imageSrc.value = '/storage/products/' + props.currentImage
    }

    if (props.currentId) {
      imageValue.value = props.currentId
      emit('update:imageValue', imageValue.value)
    }

  }
)

const isShow = ref(false)

const imageSrc = ref("")
const imageValue = ref("")

const toggleStatus = (
  () => {
    isShow.value = !isShow.value
  }
) 

const imageClick = (
  (e) => {
    // console.log(e)
    const imageName = e.target.dataset.id.substr(0, 6)
    const imageId = e.target.dataset.id.replace(imageName + '_', '')
    const imageFile = e.target.dataset.file
    const imagePath = e.target.dataset.path
    const modal = e.target.dataset.modal

    imageSrc.value = imagePath + '/' + imageFile
    imageValue.value = imageId

    emit('update:imageValue', imageValue.value)

    isShow.value = !isShow.value
  }
)

</script>

<template>
  <div v-show="isShow" class="modal" v-bind:id="modal" aria-hidden="true">
    <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" v-bind:aria-labelledby="modal + '-title'">
        <header class="modal__header">
          <h2 class="text-xl text-gray-700" v-bind:id="modal + '-title'">
            ファイルを選択してください
          </h2>
          <button v-on:click="toggleStatus" type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" v-bind:id="modal + '-content'">
          <ul v-if="props.images.length != 0" class="flex flex-wrap">
            <li v-for="image in props.images" v-bind:key="image.id" class="w-1/4 p-2 md:p-4">
              <div class="border rounded-md p-2 md:p-4">
                <img v-on:click="imageClick" class="image cursor-pointer" v-bind:data-id="props.name + '_' + image.id" v-bind:data-file="image.filename" data-path="/storage/products/" v-bind:data-modal="modal" v-bind:src="'/storage/products/' + image.filename">
                <div class="text-gray-700">
                  {{ image.title }}
                </div>
              </div>
            </li>
          </ul>
        </main>
        <footer class="modal__footer">
          <button v-on:click="toggleStatus" type="button" class="modal__btn" data-micromodal-close aria-label="閉じる">閉じる</button>
        </footer>
      </div>
    </div>
  </div>
  <div class="flex justify-around items-center mb-4">
    <button class="py-2 px-4 bg-gray-200" v-on:click="toggleStatus" type="button" v-bind:data-micromodal-trigger="modal" href='javascript:;'>ファイルを選択</button>
    <div class="w-1/4">
      <img v-bind:id="props.name + '_thumbnail'" v-bind:src="imageSrc">
    </div>
  </div>
  <!-- <input v-bind:id="props.name + '_hidden'" type="hidden" v-bind:name="props.name" v-bind:value="imageValue"> -->
</template>