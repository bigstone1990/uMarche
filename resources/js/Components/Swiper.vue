<script setup>
// import function to register Swiper custom elements
import { register } from 'swiper/element/bundle';
// register Swiper custom elements
register();

// 画面あたりの表示スライド数
const slidesPerView = 1;

// スライドとスライドの間のスペース
const spaceBetween = 0;

// スライド中のイベント
const onProgress = (e) => {
  const [swiper, progress] = e.detail;
  console.log(progress)
};

// スライド完了直後のイベント
const onSlideChange = (e) => {
  console.log('slide changed')
}

const props = defineProps({
  images: Array,
})

// slides-per-view: 画面あたりの表示スライド数
// space-between: スライドとスライドの間のスペース
// centered-slides: slides-per-viewが1より大きいときに該当スライドを中央に合わせるか始点に合わせるかの設定
// pagination: スライド下部の点群 細かい設定可能
// hideOnClick: スライドをクリックするとページネーションを非表示にするか常に表示させるかの設定
// navigation: 前後スライド移動のナビゲーション 細かい設定可能そう
// scrollbar: 全体スライド数に対する現在スライドの位置をスクロールバーで表示させるかさせないかの設定
// loop: スライドをループさせるかさせないかの設定
// speed: スライド移動を実行したときにどのくらいの時間をかけてスライドさせるかの設定
// css-mode: trueにするとマウスドラッグ操作でスライドできなくなった 他にスクロールバーやスライドがバグった… もし使うならスクロールバーを使わなかったりの設定が必要そう
</script>

<template>
  <swiper-container
    :slides-per-view="slidesPerView"
    :space-between="spaceBetween"
    :centered-slides="true" 
    :pagination="{
      hideOnClick: false
    }"
    :navigation="true"
    :scrollbar="true"
    :loop="true"
    :speed="500"
    :css-mode="false"
    @swiperprogress="onProgress"
    @swiperslidechange="onSlideChange"
  >
    <template v-if="props.images.length != 0">
      <swiper-slide v-for="image in props.images"><img :src="'/storage/products/' + image.filename" alt=""></swiper-slide>
    </template>
    <template v-else>
      <swiper-slide><img src="/images/no_image.jpg" alt=""></swiper-slide>
    </template>
  </swiper-container>
</template>