<template>
    <div class="classement">
        <div class="badge bg-pink py-2 px-3 my-3">
            <h1>Classement</h1>
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
</template>

<script>
export default {
    props: ['user'],
    data(){
        return {
            team: [],
            indexTeam: 'Erreur',
            teamAll: [],
            load: false,
        }
    },
    methods: {
       
    },
    created(){
        setTimeout(() => {       
            axios.post('api/profil/team', {
                team_id: this.user.team_id
            })
            .then((response)=> {
                this.team = response.data[1];
            })

            axios.get('api/profil/allTeam')
            .then((response)=> {
                this.teamAll = response.data;
                this.indexTeam = this.teamAll.findIndex(x => x.name == this.team.name);
            })
            .then(()=> {
                this.load = true;
            })
        },200)
    }
}
</script>

<style scoped>
h1 {
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