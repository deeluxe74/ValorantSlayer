<template>
    <div class="align-center">
        <div class="badge bg-pink my-4">
            <h1 class="color-white">Connexion</h1>
        </div>

        <form @submit.prevent="connexionUser" enctype="multipart/form-data" action="api/connexion">
            <div class="form-group">
                <label class="badge" for="exampleInputEmail1">Email</label>
                <input name="email" v-model="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label class="badge" for="exampleInputPassword1">Mot de passe</label>
                <input name="password" v-model="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-success my-4">Connecter</button>
        </form>

        <div class="align-left">
            <div class="badge badge-grey p-2">
                <router-link to="/signUp">
                    <h5>Inscription</h5>
                </router-link>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            email: '',
            password: '',
        }
    },
    methods: {
        connexionUser(){
            this.success = false;
            this.errors =false;

            axios.post(`api/connexion`, {
                email: this.email,
                password: this.password
            })
            .then((response) => {
                let rep = response.data;

                if (rep.asErrors){
                    this.$store.state.errors = rep.message;
                }else if(!rep.asErrors){
                    let token = [rep.token, rep.id];    
          
                    localStorage.setItem('user-token', JSON.stringify(token)); 

                    this.$store.state.errors = false;
                    this.$store.state.success = 'Vous êtes maintenant connectez. Félicitations !';
                    window.location.href= '/';
                }   
            })
        }
    }
}
</script>

<style scoped>

a:hover {
    text-decoration: none;
}

h1 {
    margin: 0;
}

h5 {
    font-family: 'Carter One', cursive;
    font-size: 1.5rem;
    color: white;
    margin: 0;
}

.btn {
    font-size: 1.3rem;
}
</style>