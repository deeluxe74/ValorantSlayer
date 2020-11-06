<template>
  <nav class="navbar navbar-light">
    <router-link class="navbar-brand" to="/">
      <img src="../img/logo.png" width="60" height="60" alt="Logo Valorant Slayer">
    </router-link>
    <router-link to="/connexion">
      <i @click="list = !list" class="fas fa-user-secret fa-2x"></i>
      <ul :class="list ? '' : 'out-transition'" v-if="this.$store.state.token">
        <router-link to="/profil"><li class="my-3" @click="list = false" v-if="list">Profil</li></router-link>
        <li class="mr-3" @click="logOut" v-if="list">Déconnexion</li>
      </ul>
    </router-link>
  </nav>
</template>

<script>
export default {
  data(){
    return {
      list: false
    }
  },
  methods: {
    logOut(){
      localStorage.removeItem('user-token');
      window.location.href= '/';
    },
  }
}
</script>

<style scoped>
.navbar {
  background-color: white;
  height: 10vh;
}

a{
  color: white;
}

a:hover {
  text-decoration: none;
  opacity: 1;
}

ul {
  height: 100vh;
  transition: all 0.5s ease-out;
  font-family: 'Carter One', cursive;
  color: white;
  background-color: rgb(41, 41, 41);
  position: absolute; 
  right: 0;
  font-size: 0.9rem;
  list-style-type: none;
}

.fa-user-secret {
  color: black;
}
.fa-user-secret:hover {
  opacity: 0.8;
}

li:hover {
  opacity: 0.8;
}
.out-transition {
  transform: translateX(300px);
}
</style>