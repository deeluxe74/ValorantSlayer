<template>
    <div class="mt-3" v-if="!takeGame">
        <div class="gameLive" v-if="userGames">
            <h2 class="align-start">Matchs en cours</h2>
            <table class="table table-striped">
                <tbody>
                    <tr v-for="(game, index) in userGames" v-if="game.ladder == ladder" :key="'userGames' + index" class="badge-members w-100"> 
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'">{{ game.ladder }}</td>
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'">{{ game.map1 }}</td>
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'">{{ game.status }}</td>
                        <td class="display-none" :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'"> {{ game.game_time }}</td>
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'"><router-link :to="{name: 'matchFiche', params: { game }}"><div class="badge badge-success feuille">Feuille Match</div></router-link></td>
                        <td @click="validateScore(true, index, game)" class="badge-danger" v-if="game.status == 'Fermer'">Résultat <i class="fas fa-check-square pointer"></i></td>
                        <td v-if="currUser == 'Legend'" :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'"><i @click="deleteGame(index, game)" v-if="game.status == 'Ouvert'" class="fas fa-window-close pointer"></i></td>
                    </tr>
                </tbody>
            </table>
            <div v-if="validScore" class="d-flex flex-row justify-content-between">
                <div class="align-self-center input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Votre Score :</span>
                    </div>
                    <input v-model="score1" type="number" required class="form-control">
                </div>
                <div class="align-self-center input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Score Adversaire :</span>
                    </div>
                    <input v-model="score2" type="number" required class="form-control" size="4">
                </div>
                <button @click="validateScore(false)" class="btn btn-success">Valider !</button>
            </div>
                
        </div>

        <div class="gameLive mt-3">
            <h2 class="align-start">Matchs en ce moment</h2>
            <table class="table table-striped">
                <tbody>
                    <tr v-for="(game, index) in allGames" v-if="game.ladder == ladder" :key="'allGames' + index" class="badge-members"> 
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'">{{ game.ladder }}</td>
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'">{{ game.map1 }}</td>
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'">{{ game.status }}</td>
                        <td :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'"> {{ game.game_time }}</td>
                        <td @click="takeGames(index, game)" :class="game.status == 'Ouvert' ? 'badge-success' : 'badge-danger'"><i v-if="game.status == 'Ouvert'" class="fas fa-check-square pointer"></i></td>
                    </tr>
                </tbody>
            </table> 
        </div>         
    </div>

    <div v-else>
        <div class="alert alert-primary d-flex flex-row justify-content-between flex-wrap">
            <h5 class="color-red mr-1">Rappel</h5>
            <h5>Ladder : {{ takeGameCurr.ladder }}</h5>
            <h5>Map 1: {{ takeGameCurr.map1 }}</h5>
            <h5 class="align-self-center w-100">Date/Heure : {{ takeGameCurr.game_time }}</h5>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <div class="d-flex flex-column justify-content-start">
                <h3>Slayers</h3>
                <div class="d-flex flex-row">
                     <i @click="add = !add" class="mr-3 fas fa-user-plus"></i>
                    <form v-if="add">
                        <div class="form-group d-flex flex-row">
                            <select v-model="player" name="player" class="form-control">
                                <option :value="curr" v-for="(curr,index) in playerList" :key="'player' + index">
                                    {{ curr.name }}
                                </option>
                            </select>
                            <i @click="pushPlayer(player)" class="fas fa-check color-green align-self-center ml-2 pointer"></i>
                        </div>
                     </form>
                </div>
                <h3 v-for="(curr,index) in arrPlayer" :key="'curr' + index">
                    {{ curr.name }}
                    <i @click="deleteMember(index, curr)" class="fas fa-window-close pointer"></i>
                </h3>
            </div>
        </div>
        <div class="mt-3 badge badge-grey d-flex justify-content-between">
            <img @click="map = 'Bind'" :class="map == 'Bind' ? 'active' : ''" src="../shares/img/maps/bind.png" alt="Bind">
            <img @click="map = 'Heaven'" :class="map == 'Heaven' ? 'active' : ''" src="../shares/img/maps/heaven.png" alt="Heaven">
            <img @click="map = 'Split'" :class="map == 'Split' ? 'active' : ''" src="../shares/img/maps/splite.png" alt="Split">
        </div>

        <div class="alert alert-warning">
            <p>Je certifie avoir pris connaissance des rêgles et comprend les sanctions qui peuvent suivre.</p>
        </div>
        <button @click="createGame" class="btn bg-pink mb-5">Slay !</button>
    </div>
</template>

<script>

import { DateTime } from 'luxon';
export default {
    props: ['playerList', 'ladder', 'playerNeeded'],
    data(){
        return {
            userGames: [],
            allGames: [],
            currUser: false,
            takeGame: false,
            takeGameCurr: [],
            // For form complete
            add: false,
            arrPlayer: [],
            player: null,
            map: null,

            validScore: false,
            score1:null,
            score2:null
        }
    },
    methods: {
        deleteGame(index, game){
            if(game.status == 'Ouvert' && this.currUser == 'Legend'){
                axios.post(`api/match/deleteGame`, {
                    pass_match : game.pass_match
                })
                .then((response) => {
                    this.$store.state.success = response.data.success;
                    this.userGames.forEach((game) => {
                        if(game.pass_match == response.data.pass_match) {
                            this.userGames.splice(this.userGames.indexOf(game), 1);
                        }
                    })
                })
            }else {
                this.$store.state.errors = "Une erreur et survenue veuillez recharger la page."
            }
        },
        takeGames(index, game){
            if(game.pass_match != null && game.score1 == null && game.status == 'Ouvert'){
                this.takeGame = true;
                this.takeGameCurr = game;
            }
        },// For FORM
         pushPlayer(player){
            let errors = false;
            this.arrPlayer.forEach(curr => {
                if (curr == player){
                    errors = true;
                    this.$store.state.errors = "Tu ne peut pas ajouter deux fois le même joueur."
                }
            });
            if(!errors){
                this.playerList.splice(this.playerList.indexOf(player),1);
                this.arrPlayer.push(player);
            }
        },
        deleteMember(id, player){
            this.playerList.push(player);
            this.arrPlayer.splice(id,1);
        },
        createGame(){
            let token = JSON.parse(this.$store.state.token);

            if(this.playerNeeded == this.arrPlayer.length){
                if(this.map != null){
                    axios.post(`api/match/createGame`, {
                        map: this.map,
                        token: token[0],
                        pass_match: this.takeGameCurr.pass_match,
                        arr_player: this.arrPlayer
                    })
                    .then((response) => {
                        this.$store.state.success = response.data.success;
                        this.allGames.splice(this.allGames.indexOf(this.takeGameCurr),1);
                        this.userGames.push(response.data.game);
                        this.takeGame = false;
                        this.arrPlayer = [];  
                    })
                }
            }else {
                this.$store.state.errors = "Le nombre de joueurs requis n'est pas correct : " + this.playerNeeded;
            }
        },
        validateScore(justSave, index, game){
            //Save the currGame
            if(justSave){
                let date = new Date();
                let today = new Date();
                const dd = today.getDate();
                const mm = today.getMonth() + 1;
                const yyyy = today.getFullYear();
                const hh = today.getHours();
                const min = today.getMinutes();
                
                const yyyyGame = game.game_time[6] + game.game_time[7] + game.game_time[8] + game.game_time[9];
                const mmGame = game.game_time[3] == 0 ? '' + game.game_time[4] : game.game_time[3] + game.game_time[4];
                const ddGame = game.game_time[0] == 0 ? '' + game.game_time[1] : game.game_time[0] + game.game_time[1];
                const hhGame = game.game_time[11] == 0 ? '' + game.game_time[12] : game.game_time[11] + game.game_time[12];
                const minGame = game.game_time[14] == 0 ? '' + game.game_time[15] : game.game_time[14] + game.game_time[15];

                let success = false;
                let errors = false;
                if(yyyyGame > yyyy){
                    this.errors = true;
                }else{
                    if(mmGame < mm){
                        success = true;
                    }else if(mmGame == mm){
                        if(ddGame < dd){
                            success = true;
                        }else if(ddGame == dd){
                            if(hhGame < hh){
                                success = true;
                            }else if(hhGame == hh){
                                if(minGame <= min){
                                    success = true;
                                }
                                else {
                                    errors = true;
                                }
                            }
                            else {
                                errors = true;
                            }
                        }
                        else {
                            errors = true;
                        }
                    }
                    else {
                        errors = true;
                    }
                }
            if(success){
                this.validScore = true;
                this.takeGameCurr = game;
            }else if(errors){
               this.$store.state.errors = "Pour rentrer un score la date du match doit être passer !" 
            }
            }else {
                let token = JSON.parse(this.$store.state.token);
                axios.post(`api/match/validateScore`, {
                    token: token[0],
                    game_pass : this.takeGameCurr.pass_match,
                    score1: this.score1,
                    score2: this.score2
                })
                .then((response) => {
                    this.$store.state.success = response.data.success;
                    this.validScore = false;
                    this.userGames.splice(this.userGames.indexOf(this.takeGameCurr),1);
                });
            }

        }
    },
    created(){
        let token = JSON.parse(this.$store.state.token);
        axios.post(`api/match/show`, {
            ladder: '5vs5',
            token: token[0]
        })
        .then((response) => {
            this.currUser = response.data[2];  
            this.userGames = response.data[1];
            this.allGames = response.data[0];
        })
    }
}
</script>

<style scoped>
h2 {
    font-family: 'Carter One', cursive;
    color: white;
}
h3 {
    font-size: 1.3rem;
    font-family: 'Carter One', cursive;
    color: black;
}

h5 {
    font-size: 1rem;
    font-family: 'Carter One', cursive;
}

a {
    text-decoration: none;
    color: white;
}

table {
    border-collapse:separate; 
    border-spacing:0 8px; 
}

td {
    padding: 0.3rem 0;
    font-size: 0.8rem;
    font-family: 'Carter One', cursive;
    margin: 0;
    border: none;
}

#forceBg  {
    background-color: rgb(52, 221, 0);
}
.badge-members {
    color: black;
}

.gameLive {
    color: white;
    padding: 1.5rem 0.7rem;
    border-radius: 15px;
    background-color: #161616;
}

.fa-window-close {
    font-size: 0.9rem;
    color: rgb(207, 5, 5);
}

.fa-check-square {
    font-size: 1rem;
    color: rgb(255, 255, 255);
}

.feuille {
    font-size: 0.8rem;
}

/* Form for accept game */
.fa-user-plus {
    font-size: 1.3rem;
}

.form-control {
    height: 40px;
}

.active {
    border: rgb(3, 154, 214) 5px solid;
    transform: translateY(-10px);
}

.btn {
    font-family: 'Carter One', cursive;
    font-size: 2rem ;
    font-weight: 600;
}

.btn-success {
    font-size: 1rem;
}

img {
    transition: all ease-out 400ms;
    height: 110px;
    width: 90px;
    border-radius: 5px;
}

.input-group {
    width: 20vw;
}

@media screen and (max-width: 400px){
    .display-none {
        display: none;
    }
    .feuille {
        font-size: 0.7rem;
    }
}
</style>