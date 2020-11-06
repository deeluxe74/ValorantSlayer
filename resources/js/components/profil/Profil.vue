<template>
    <div v-if="profil">
        <div class="align-center mt-3"><div class="badge badge-grey"><h1>Profil</h1></div></div>
  
        <div class="my-3">
            <button @click="profil = !profil" class="btn btn-dark">Ma Team</button>
            <button class="btn btn-dark">Editer</button>
        </div>
        <div class="align-center mb-2">
            <img class="profilImg" :src="user.picture" alt="image de profil">
        </div>
        <h5><span>Pseudo:</span> {{ user.name }}</h5>
        <h5 v-if="user.team"><span>Team: </span>{{ user.team }}</h5>
        <h5><span>Email: </span>{{ user.email }}</h5>
        <h5 class="align-center"><span>Secret: </span><div class="secret">{{ user.pass_team }}</div></h5>

        <div class="classement">
            <div class="classement" v-if="load">
                <div class="badge bg-pink py-2 px-3 my-3">
                    <h1 class="color-white">Classement</h1>
                </div>
                <br>
                <table class="table table-striped" v-if="load">
                    <tbody>
                        <tr id="forceBg" class="badge-members"> 
                            <td class="color-gold">#{{ indexTeam +1 }}</td>
                            <td class="color-white">{{ team.name }}</td>
                            <td class="color-white">{{ team.score }}</td>
                            <td class="color-white"><span class="color-green">{{ team.victory == null ? '0' : team.victory }}</span>/<span class="color-blue">{{ team.equal == null ? '0' : team.equal }}</span>/<span class="color-red">{{ team.defeat == null ? '0' : team.defeat }}</span></td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </div>
    </div>

    <div v-else>
        <team @profil="profilState" :user="user"></team>
    </div>
</template>

<script>
import Classement from '../../shares/components/Classement';
import Team from './Team';

export default {
    components: {
        Classement,
        Team
    },
    data(){
        return {
            profil: true,
            user: {},
            team: [],
            indexTeam: 'Erreur',
            teamAll: [],
            load: false,
        }
    },
    methods: {
        profilState(val){
            this.profil = val;
        },
    },
    beforeCreate(){
        const token = JSON.parse(localStorage.getItem('user-token'));
        
        axios.post(`api/profil`, {
            token: token[0],
            id: token[1]
        })
        .then((response)=> {
            this.user = response.data; 
            axios.post('api/profil/team', {
                team_id: this.user.team_id
            })
            .then((response)=> {
                this.team = response.data[1];
                axios.get('api/profil/allTeam')
                .then((response)=> {
                    this.teamAll = response.data;
                    this.indexTeam = this.teamAll.findIndex(x => x.name == this.team.name);
                })
                .then(()=> {
                    this.load = true;
                })
            })   
        });
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

h4 {
    font-size: 1rem;
    font-weight: 700;
}

h5 {
    line-height: 1.6rem;
    font-weight: 600;
}

span {
    font-weight: 300;
}

.btn {
    font-family: 'Carter One', cursive;
    font-size: 1.2rem ;
    color: white;
}

.profilImg {
    width: 65vw;
    height: 20vh;
    position: static;
    right: 20px;
}

.badge-grey {
    padding: 0.5rem 1.4rem;
}

.secret {
    font-size: 0.9rem;
    font-weight: 500;
    word-wrap: break-word;
}

@media screen and (min-width: 600px) {
    .profilImg {
        width: 30vw;
        height: 20vw;
        right: 10vw;
    }
}


table {
    border-collapse:separate; 
    border-spacing:0 15px; 
}

td {
    font-size: 1.1rem;
    font-family: 'Carter One', cursive;
    margin: 0;
}

h3 {
    text-align: left;
    font-size: 1.6rem;
}

#forceBg {
    background-color: #242424;
}

.classement {
    text-align: center;
}

@media screen and (max-width: 380px) {
    td {
        font-size: 0.8rem;
    }
}
</style>