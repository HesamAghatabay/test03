<template>
  <q-page class="q-pa-md">
    <div class="q-pa-md row justify-center">
      <div style="width: 100%; max-width: 400px">
        <q-chat-message :text="['hey, how are you?']" sent />
        <q-chat-message :text="['doing fine, how r you?']" />
      </div>
    </div>
  </q-page>
</template>

<script setup>
import { api } from 'src/boot/axios'
import { onMounted, ref } from 'vue'

const messages = ref([])

onMounted(() => {
  api
    .get('api/getMessages')
    .then((r) => {
      messages.value = r.data
    })
    .catch((e) => {
      console.error(e)
    })
})
</script>
