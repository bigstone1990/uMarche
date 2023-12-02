<script setup>
import 'https://js.stripe.com/v3/'
import { onMounted } from 'vue';

const props = defineProps({
  session: Object,
  publicKey: String,
})

const stripe = Stripe(props.publicKey)

onMounted(
  () => {
    stripe.redirectToCheckout({
      sessionId: props.session.id,
    }).then(function(result){
      window.location.href = route('user.cart.index')
    })
  }
)

// onMounted(
//   () => {
//     route(session.url)
//   }
// )

</script>

<template>
  <p>決済ページへリダイレクトします。</p>
</template>