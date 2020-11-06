<template>
    <div class="mt-4">
        <h1 class="mt-3">Bienvenue Chez Valorant Slayer Victory</h1>
        <h4 class="align-center mt-3">Pour accèder a ce contenue tu dois te connecter ou crée ton compte.</h4>
        <div class="align-center mt-5">
            <router-link to="/connexion"><button class="btn btn-success mr-5">Connection</button></router-link>
            <router-link to="/signUp"><button class="btn btn-success">Inscription</button></router-link>
         </div>
        <div class="d-flex justify-content-center mt-4">
            <img src="../shares/img/logo.png" alt="Logo Slayer">
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
h4 {
    font-size: 1rem;
}
img {
    width: 300px;
}
</style>