<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>

<template>
  <main>
    <div>
      <h1 class="sriracha-regular big-text text-center">Aspirante</h1>
      <p class="text-center">Productivity</p>
    </div>

    <div>
      Login
      <input type="text" name="" id="" class="input input-bordered w-full" />
    </div>

    <div>
      Password
      <input type="password" name="" id="" class="input input-bordered w-full" />
    </div>

    <div class="flex justify-center">
      <RouterLink to="/calendar" class="btn btn-wide btn-accent text-right">Sign in</RouterLink>
      <!-- <a href="#" class="btn btn-wide btn-accent text-right">Sign in</a> -->
      <!-- <a href="#" class="btn btn-wide btn-accent text-right">Sign in</a> -->
    </div>

    <div>
      <a href="#" class="text-center block">Forgot my password</a>
    </div>

    <div>
      <a href="#" class="text-center block">New here? Click here to sign up.</a>
    </div>
  </main>
</template>

<style scoped>
.sriracha-regular {
  font-family: 'Sriracha', serif;
  font-weight: 400;
  font-style: normal;
}

.big-text {
  font-size: 48px;
}
</style>
