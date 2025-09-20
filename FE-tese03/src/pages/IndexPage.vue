<template>
  <q-page class="q-pa-md">
    <div class="q-pa-md row justify-center">
      <div style="width: 100%; max-width: 400px">
        <q-chat-message
          v-for="(message, index) in messages"
          :key="'message' + index"
          :text="[message.content]"
          sent
        />
      </div>
    </div>
    <div style="width: 600px; position: absolute; bottom: 20px">
      <q-input outlined v-model="text" label="Outlined" />
      <q-btn @click="send">send</q-btn>
    </div>
  </q-page>
</template>

<script setup>
import { api } from 'src/boot/axios'
import { onMounted, ref } from 'vue'

const messages = ref([])
const text = ref('')

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

function send() {
  api
    .post('api/send', {
      text: text.value,
    })
    .then((r) => {
      console.log(r.data)
    })
    .catch((e) => {
      console.error(e)
    })
}
</script>
