```vue
<template>
  <q-page class="q-pa-md flex flex-center bg-grey-2">
    <q-card flat bordered class="full-width" style="max-width: 500px; height: 80vh">
      <!-- نوار بالای چت -->
      <q-toolbar class="bg-primary text-white">
        <q-toolbar-title>صفحه چت برای تست</q-toolbar-title>
        <q-btn flat round dense icon="more_vert" color="white" />
      </q-toolbar>

      <!-- محتوای پیام‌ها -->
      <q-scroll-area ref="chatScroll" class="q-pa-md col" style="height: calc(100% - 110px)">
        <q-chat-message
          v-for="(message, index) in messages"
          :key="'message' + index"
          :name="message.user_name ?? message.user.name"
          sent
          :text="[message.content]"
          class="q-ma-sm"
        />
      </q-scroll-area>

      <!-- بخش ورودی پیام -->
      <div class="row items-center q-pa-sm bg-grey-1" style="position: sticky; bottom: 0">
        <q-input
          rounded
          outlined
          dense
          v-model="text"
          placeholder="پیام خود را بنویسید..."
          class="col-grow q-mr-sm"
          @keyup.enter="send"
        >
          <template v-slot:append>
            <q-icon name="emoji_emotions" class="cursor-pointer" />
          </template>
        </q-input>
        <q-btn round color="primary" icon="send" @click="send" />
      </div>
    </q-card>
  </q-page>
</template>
```

<script setup>
import { api } from 'src/boot/axios'
import echo from 'src/boot/echo'
import { nextTick, onMounted, ref } from 'vue'

const messages = ref([])
const me = ref('')
const text = ref('')
const chatScroll = ref(null)

function scrollToBottom() {
  nextTick(() => {
    if (chatScroll.value) {
      chatScroll.value.setScrollPercentage('vertical', 1)
    }
  })
}

onMounted(() => {
  api
    .get('api/getMessages')
    .then((r) => {
      messages.value = r.data.messages
      me.value = r.data.me
      scrollToBottom()
    })
    .catch((e) => {
      console.error(e)
    })
  echo.channel('chat').listen('MessageSent', (e) => {
    console.log('New message:', e)
    messages.value.push(e)
    scrollToBottom()
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
