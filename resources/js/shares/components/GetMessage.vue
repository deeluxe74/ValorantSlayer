<template>
  <div class="message">
        <div v-if="errors" class="alert alert-danger">{{ errors }}</div>
        <div v-if="success" class="alert alert-success">{{ success }}</div>
  </div>
</template>

<script>


export default {
    props: ['errors', 'success'],

}
</script>

<style scoped>
.message {
  z-index: 10;
  opacity: 0.6;
}

.alert {
  font-size: 0.8rem;
  margin: 20px 0%;
}
</style>