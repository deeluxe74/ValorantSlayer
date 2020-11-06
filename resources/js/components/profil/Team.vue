<template>
    <div>
        <div class="align-center mt-3"><div class="badge badge-grey"><h1>{{ team.name || 'Team' }}</h1></div></div>
        <div v-if="user.team_id">
            <div class="mb-5 d-flex flex-row justify-content-between">
                <div class="d-flex flex-column justify-content-start">
                    <div><button @click="profilState" class="btn btn-dark"><i class="fas fa-reply"></i></button></div>
                    <div class="mt-4">
                        <h5><span>Membres:</span> {{ members.length }} </h5>
                        <h5><span>Leader:</span> {{ legend }}</h5>
                    </div>
                    
                </div>
                <img class="logo mt-3" :src="team.logo" alt="image de Team">
            </div>
            <div v-if="loaded" class="details d-flex flex-column">
                <table class="table table-striped">
                    <tbody>
                        <tr id="forceBg" v-for="(member, index) in members" :key="'members' + index" class="badge-members"> 
                            <td>{{ member.name }}</td>
                            <td>{{ member.roles }}</td>
                            <td class="align-center"><span class="color-green">{{ member.win }}</span>/<span class="color-blue">{{ member.equal == null ? '0' : member.equal }}</span>/<span class="color-red">{{ member.loose == null ? '0' : member.loose }}</span></td>
                            <td class="align-end"><i @click="deleteMember(member.id)" class="fas fa-window-close color-white"></i></td>
                        </tr>
                    </tbody>
                </table>      
            </div>
            <i @click="addPlayer = !addPlayer" :class="addPlayer ? '' : 'mb-5'" class="mr-3 fas fa-user-plus pointer"></i>
            <form @submit.prevent="newMember" v-if="addPlayer">
                <div class="form-group">
                    <label class="badge" for="secretPass">Secret pass</label>
                    <input v-model="secretPass" type="text" class="form-control" required>
                </div>
                <button type="submit" class="mb-4 btn btn-success">Envoyer</button>
            </form>
        </div>

        <div v-else>
            <div class="badge bg-pink p-2 mb-5"><h2>Crée ma team</h2></div>

            <form @submit.prevent="createTeam" action="api/profil/team">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nom de la team</label>
                    <input maxlength="8" v-model="name" name="name" type="text" class="form-control" id="exampleFormControlInput1" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Votre logo (lien direct)</label>
                    <input v-model="logo" name="logo" type="text" class="form-control" id="exampleFormControlInput1" placeholder="https://hebergeur.net/up/20/16/p3c6.png">
                </div>
                <button type="submit" class="btn btn-success my-4">Création</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data(){
        return {
            name: '',
            logo: '',
            legend: 'Indisponible',
            team: {},
            members: [],
            addPlayer: false,
            secretPass: '',
            scores: {},
            loaded: false
        }
    },
    methods: {
        createTeam(){
            axios.post(`api/profil/newTeam`, {
                name: this.name,
                logo: this.logo,
                userId: this.user.id,
            })
            .then((response)=> {
                if(response.data.errors){
                    this.$store.state.errors = response.data.errors;
                }else {
                    this.getTeam(response.data.team_id),
                    this.$store.state.success = "Félicitation vous avez crée votre team ! Vous êtes le leader."
                    this.user.team_id = response.data.team_id;
                }
            })
        },
        getTeam(userId){
            if(userId){
                axios.post(`api/profil/team`, {
                    team_id: userId
                })
                .then((response) => {
                    this.loose = response.data[3]
                    this.win = response.data[2];
                    this.team = response.data[1];
                    this.members = response.data[0];
                    this.members.forEach(member => {
                       if (member.roles == 'Legend'){
                           this.legend = member.name;
                       }
                    });
                })
                .then(()=> {
                    this.win.forEach(win => {
                        if(win.length > 0) {
                            this.members.forEach(member => {
                                if (member.id == win[0].user_id){
                                    member.win = win.length;
                                }
                        })
                        }
                    });
                    this.loose.forEach(loose => {
                        if(loose.length > 0){
                            this.members.forEach(member => {
                                if (member.id == loose[0].user_id){
                                    member.loose = loose.length;
                                }
                            })
                        }
                    });
                    this.loaded = true;
                })
            }
        },
        profilState(){
            this.$emit('profil', true);
        },
        newMember(){
            axios.post(`api/profil/team/newMember`, {
                secret_pass: this.secretPass,
                team_id: this.team.id
            })
            .then((response) => {
                if(response.data.errors){
                    this.$store.state.errors = response.data.errors;
                }else {
                    this.secretPass = '';
                    this.getTeam(response.data.id);
                    this.$store.state.success = 'Un nouveau membre a été ajouter dans votre team !'
                }
            })
        },
        deleteMember(id){
            axios.post(`api/profil/team/deleteMember`, {
                user_id: id
            })
            .then((response) => {
                if(response.data.errors){
                    this.$store.state.errors = response.data.errors;
                }else {
                    this.$store.state.success = response.data.success;
                    this.getTeam(response.data.id);
                }
            })
        }
    },
    created(){
        this.getTeam(this.user.team_id);
    }
}
</script>

<style scoped>
h1 {
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 2.3rem;
}

h2 {
    font-family: 'Carter One', cursive;
    font-size: 1.1rem ;
    font-weight: 600;
    color: white;  
    margin: 0;  
}
table {
    border-collapse:separate; 
    border-spacing:0 15px; 
}

td {
    font-size: 1.1rem;
    font-family: 'Carter One', cursive;
    margin: 0;
    border: none;
}

#forceBg  {
    background-color: #242424;
}

h5 {
    line-height: 1.6rem;
    font-weight: 600;
}

span {
    font-weight: 300;
}

.btn {
    text-align: center;
    font-size: 1.2rem;
    font-family: 'Carter One', cursive;
    color: white;
}

.btn-dark {
    padding: 0.2rem 0.5rem;
}

.logo {
    width: 45vw;
    height: 20vh;
}

.name {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.5rem;
    text-align: center;
    color: black;
}

.badge-grey {
    padding: 0.5rem 1.4rem;
}

.badge-members {
    padding: 0.5rem 1rem;
    background-color: #202020;
    border-radius: 2px;
    color: white;
}

.fa-reply {
    margin: 0;
    padding: 0;
}

.fa-window-close {
    cursor: pointer;
    font-size: 1.3rem;
    color: rgb(253, 20, 20);
}

@media screen and (min-width: 800px) {
    .logo {
        width: 20vw;
        height: 20vw;
    }
}
</style>