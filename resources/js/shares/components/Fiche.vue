<template>
    <div>
        <router-link to="/match"><i class="fas fa-reply color-red"></i></router-link>
        <div class="d-flex flex-column mt-4">
            <div class="badge-grey p-2">
                <div class="d-flex flex-row justify-content-evenly">
                    <div class="d-flex flex-column justify-content-between">
                        <img class="mb-2" :src="currTeam.logo" alt="logo equipe 1">
                        <h2>{{ currTeam.name }}</h2>
                        <h5 class="align-center"><span class="color-green">{{ currTeam.victory }}</span>/<span class="color-blue">{{ currTeam.equal }}</span>/<span class="color-red">{{ currTeam.defeat }}</span></h5>
                        <h4 class="align-center">Map</h4>
                        <h3 class="align-center">{{ game.map1 }}</h3>
                    </div>
                    <div class="d-flex flex-column justify-content-between">
                        <img class="mb-2" :src="guestTeam.logo" alt="logo equipe 2">
                        <h2>{{ guestTeam.name }}</h2>
                        <h5 class="align-center"><span class="color-green">{{ guestTeam.victory }}</span>/<span class="color-blue">{{ guestTeam.equal }}</span>/<span class="color-red">{{ guestTeam.defeat }}</span></h5>
                        <h4 class="align-center">Map</h4>
                        <h3 class="align-center">{{ game.map2 }}</h3>
                    </div>
                </div>
                <h4 class="align-center date py-2">{{ game.game_time }}</h4>
            </div>
        </div>

        <div class="team1 mt-3">
            <h1>{{ currTeam.name }}</h1>
            <table class="table table-striped">
                <tbody>
                    <tr v-for="(player, index) in currPlayers" :key="'currPlayer' + index" id="forceBg" class="badge-members"> 
                        <td class="color-green">{{ player.name }}</td>
                        <td>{{ player.roles }}</td>
                        <td class="color-gold">{{ currTeam.score }}</td>
                    </tr>
                </tbody>
            </table>      
        </div>
        <div class="team2">
            <h1>{{ guestTeam.name }}</h1>
            <table class="table table-striped">
                <tbody>
                    <tr v-for="(player, index) in guestPlayers" :key="'guestPlayer' + index" id="forceBg" class="badge-members"> 
                        <td class="color-red">{{ player.name }}</td>
                        <td>{{ player.roles }}</td>
                        <td class="color-gold">{{ guestTeam.score }}</td>
                    </tr>
                </tbody>
            </table>      
        </div>
    </div>
</template>

<script>
export default {
    props: ['game'],
    data(){
        return {
            players: [],
            currPlayers: [],
            guestPlayers: [],
            guestTeam: [],
            currTeam: []
        }
    },
    created(){
        let token = JSON.parse(this.$store.state.token);
        axios.post(`api/fiche`,{
            pass_match: this.game.pass_match,
            token: token[0]
        })
        .then((response) => {
            this.currPlayers = response.data.currPlayers;
            this.guestPlayers = response.data.guestPlayers;
            this.guestTeam = response.data.guestTeam;
            this.currTeam = response.data.currTeam;
        })
    }
}
</script>

<style scoped>
h1 {
    color: black;
    font-size: 1.5rem;
}

h2 {
    color: white;
    font-size: 1.2rem;
    font-weight: 800;
}

h3 {
    font-family: 'Carter One', cursive;
    font-size: 1.2rem;
}

h4 {
    font-weight: 100;
}

h5 {
    font-family: 'Carter One', cursive;
    font-size: 1.2rem;
}

table {
    border-collapse:separate; 
    border-spacing:0 8px; 
}

td {
    color: white;
    padding: 0.3rem 0.5rem;
    font-size: 1rem;
    font-family: 'Carter One', cursive;
    margin: 0;
    border: none;
}

img {
    height: 100px;
    width: 110px;
}

#forceBg  {
    background-color: #242424;
}

.title {
    font-size: 1.6rem;
    font-family: 'Carter One', cursive;
    font-weight: 100;
    color: rgb(172, 3, 14);
}

.date {
    font-size: 1rem;
    font-weight: 300;
}

.badge-members {
    color: black;
}
</style>