<script setup lang="ts"></script>

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
      <a href="#" class="btn btn-wide btn-accent text-right">Sign in</a>
    </div>

    <div class="flex">
      <a href="#" class="text-center block">Forgot my password</a> |
      <a href="#">New here? Click here to sign up.</a>
    </div>

    <div class="block text-center"></div>

    <div class="block text-center"><a href="#">Continue without signing in</a></div>
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
