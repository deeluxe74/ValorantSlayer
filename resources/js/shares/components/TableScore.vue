<template>
    <div>
        <div v-if="choice && !ficheTeam">
            <div class="badge badge-grey d-flex flex-row justify-content-between">
                <div class="badge bg-pink align-self-center p-2">Ladder Officiel</div>
            </div>
            <div class="badge badge-grey my-4">
                <h1 class="rank px-3">Rank</h1>
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr @click="displayTeam(team, index)" v-for="(team, index) in allTeams" :key="'team' + index" id="forceBg" class="pointer badge-members"> 
                        <td class="color-gold">#{{ index +1 }}</td>
                        <td class="color-white">{{ team.name }}</td>
                        <td class="color-white">{{ team.score }}</td>
                        <td class="color-white"><span class="color-green">{{ team.victory == null ? '0' : team.victory }}</span>/<span class="color-blue">{{ team.equal == null ? '0' : team.equal }}</span>/<span class="color-red">{{ team.defeat == null ? '0' : team.defeat }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="ficheTeam">
            <fiche-team :team="team"></fiche-team>
        </div>
    </div>
    
   
</template>

<script>
import FicheTeam from './FicheTeam';

export default {
    props: ['choice'],
    components: {
        FicheTeam,
    },
    data(){
        return {
            allTeams: [],
            ficheTeam: false,
            team: []
        }
    },
    methods: {
        displayTeam(team, index) {
            this.team = team;
            this.ficheTeam = true;

        }
    },
    created(){
       axios.get('api/profil/allTeam')
        .then((response) => {
            this.allTeams = response.data;
        })
    }
}
</script>

<style scoped>
table {
    max-width: 100vw;
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

.choice {
    text-align: center;
    margin-top: 40px;
}

.rank {
    font-size: 2rem;
}

.badge-members:hover {
    transform: translateY(-4px);
    opacity: 0.8;
}
</style>