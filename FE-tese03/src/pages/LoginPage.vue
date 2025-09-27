<template>
  <q-page padding>
    <!-- content -->
    <h5>login page</h5>
    <q-input outlined v-model="user.email" label="email" />
    <q-input outlined v-model="user.password" label="password" />
    <q-btn @click="login">login</q-btn>
  </q-page>
</template>

<script setup>
import { Notify } from 'quasar'
import { api } from 'src/boot/axios'
import { reactive } from 'vue'
import { useRouter } from 'vue-router'

const user = reactive({
  email: '',
  password: '',
})

const router = useRouter()

function login() {
  api
    .post('oauth/token', {
      grant_type: 'password',
      client_id: '9ffaa889-3832-42e1-8045-f4b6681d2b36',
      client_secret: 'dlWyQVZuWg3SGq0nEwAa8hegXoGRTMq32PgwveEm',
      username: user.email,
      password: user.password,
      scope: '*',
    })
    .then((r) => {
      if (r.data.access_token) {
        localStorage.setItem('access_token', r.data.access_token)
        api.defaults.headers = {
          Authorization: 'Bearer ' + r.data.access_token,
          'Content-Type': 'application/json',
          Accept: 'application/json;charset=UTF-8',
        }
        router.replace('/')
        Notify.create({ message: '😍 خوش اومدی', color: 'positive', position: 'top' })
      }
    })
    .catch((e) => {
      console.error(e)
    })
}
</script>
