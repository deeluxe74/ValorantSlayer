<template>
  <div class="barApp w-100">
      <div class="d-flex flex-row justify-content-around align-items-center">
            <router-link class="align-self-center" to="/match">
                <i class="fas fa-play color-pink"></i>
            </router-link>
            <router-link to="/score">
                <i class="fas fa-trophy fa-2x"></i>
            </router-link>
            <router-link to="/info">
                <i class="far fa-question-circle fa-2x"></i>
            </router-link>

      </div>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
a {
    line-height: 0;
}
.fa-question-circle {
    font-size: 3.2rem;
}
.fa-play {
    font-size: 2.9rem;
}

.barApp {
    padding: 0.8rem 1rem!important;
    box-shadow: 0px 11px 20px 7px rgba(0,0,0,0.75);
    height: auto;
    background-color: rgb(255, 255, 255);
}

.fa-trophy {
    color: #F3C30B;
}
.fa-question-circle {
    color: #54A6A4;
}
</style>