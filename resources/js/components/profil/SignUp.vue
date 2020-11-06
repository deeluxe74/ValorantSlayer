<template>
    <div class="align-center">
        <div class="badge bg-pink my-4">
            <h1 class="color-white">Inscription</h1>
        </div>

        <form method="POST" enctype="multipart/form-data" action="api/signUp">
            <div class="row">
                <div class="col">
                    <label for="pseudo">Pseudo</label>
                    <input maxlength="9" v-model="name" name="name" type="text" class="form-control" required placeholder="Deeluxe">
                </div>
                <div class="col">
                    <label for="email">Email</label>
                    <input v-model="email" name="email" type="email" class="form-control" required placeholder="text@gmail.com">
                </div>
            </div>
            <div class="row my-4">
                <div class="col">
                    <label for="password">Mots de passe</label>
                    <input v-model="password" name="password" type="password" required class="form-control">
                </div>
                <div class="col">
                     <label for="password">Confirmation</label>
                    <input v-model="password2" type="password" required class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col">
                    <label for="img">Image de Profil (lien)</label>
                    <input v-model="picture" name="picture" type="text" class="form-control">
                </div>
            </div>

            <button v-if="password == password2" type="submit" class="btn btn-primary mt-3">S'inscrire</button>
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: '',
            email: '',
            password: '',
            password2: '',
            picture: '',

        }
    }
}
</script>

<style scoped>


.col {
    text-align: left;
}

.btn {
    font-size: 1.2rem;
}
</style>