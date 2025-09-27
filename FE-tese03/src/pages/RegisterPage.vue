<template>
  <q-page padding>
    <!-- content -->
    <h5>register page</h5>

    <q-input outlined v-model="user.name" label="name" />
    <q-input outlined v-model="user.email" label="email" />
    <q-input outlined v-model="user.password" label="password" />
    <q-btn @click="register">register</q-btn>
  </q-page>
</template>

<script setup>
import { api } from 'src/boot/axios'
import { reactive } from 'vue'

const user = reactive({
  name: '',
  email: '',
  password: '',
})

function register() {
  api
    .post('api/register', user)
    .then((r) => {
      console.log(r.data)
    })
    .catch((e) => {
      console.error(e)
    })
}
</script>
