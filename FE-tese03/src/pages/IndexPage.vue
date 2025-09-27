<template>
  <q-page class="q-pa-md q-page">
    <div class="q-pa-md row justify-center">
      <div style="width: 100%; max-width: 400px; padding-bottom: 130px">
        <q-chat-message
          v-for="(message, index) in messages"
          :key="'message' + index"
          :name="message.user_name ?? message.user.name"
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
import echo from 'src/boot/echo'
import { nextTick, onMounted, ref } from 'vue'

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
  echo.channel('chat').listen('MessageSent', (e) => {
    console.log('New message:', e)
    messages.value.push(e)
    nextTick(() => {
      const container = document.querySelector('.q-page')
      container.scrollTop = container.scrollHeight
    })
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
    .finally(() => {
      text.value = ''
    })
}
</script>
