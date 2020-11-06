<template>
    <div>
        <h1 class="mt-4 ladder">Ladders Ouvert</h1>
        <router-link to="/"><i class="fas fa-reply color-red"></i></router-link>
        <ladder v-if="!ladder" @myLadder="getLadder"></ladder>
        
        <div v-if="ladder" class="align-center">
            <div class="ladder mt-4">
                <div class="badge badge-grey d-flex flex-row justify-content-between">
                    <h3 v-if="ladder == '5vs5'">5 vs 5</h3>
                    <h3 v-if="ladder == '2vs2'">2 vs 2</h3>
                    <div class="badge bg-pink align-self-center p-2">Ladder Officiel</div>
                </div>
            </div>
            <div v-if="match != 'show'" class="badge badge-grey">
                <h1>Match</h1>
            </div>
            
            <div v-if="!match">
                <button @click="match = 'create'" class="btn bg-pink match align-wrap">Crée un match</button>
                <button @click="match = 'show'" class="ml-2 btn bg-pink match">Voir les matchs</button>

                <img class="logo" src="../shares/img/logo2.png" alt="logo Slayer">
            </div>

            <div v-if="match == 'create'">
                <div class="d-flex flex-row flex-wrap justify-content-between">
                    <div class="d-flex flex-column justify-content-start align-wrap">
                        <h2>Slayers</h2>
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
                        <h2 v-for="(curr,index) in arrPlayer" :key="'curr' + index">
                            {{ curr.name }}
                            <i @click="deleteMember(index, curr)" class="fas fa-window-close pointer"></i>
                        </h2>
                    </div>
                    <div class="d-flex flex-column">
                        <h2>Date</h2>
                        <datetime class="datetime" v-model="time" :min-datetime="date" type="datetime" zone="Europe/Paris" value-zone="Europe/Paris"></datetime>
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

            <div v-if="match == 'show'">
                <match-show :playerList="playerList" :ladder="ladder" :playerNeeded="playerNeeded"></match-show>
            </div>
        </div>
    </div>
</template>

<script>
import Ladder from '../shares/components/Ladder';
import MatchShow from './MatchShow';
import { Datetime } from 'vue-datetime';
import { DateTime as luxon } from 'luxon';

export default {
    components: {
        Ladder,
        Datetime,
        MatchShow
    },
    data() {
        return {
            match: false,
            ladder: false,
            add: false,
            player: null,
            playerNeeded: null,
            playerList : [],
            arrPlayer: [],
            time: null,
            map: null,
            date : null,

        }
    },
    methods: {
        getLadder(val){
            this.ladder = val;
        },
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
        createGame(){
            
            let token = JSON.parse(this.$store.state.token);
            //Count player is good
            if(this.playerNeeded == this.arrPlayer.length){
                //Check all params required
                if(this.map != null && this.time != null){
                    //Check if count player is good
                    this.time = luxon.fromISO(this.time).toFormat('dd/MM/yyyy hh:mm');
                    axios.post(`api/match/createGame`, {
                        map: this.map,
                        ladder: this.ladder,
                        token: token[0],
                        game_time: this.time,
                        arr_player: this.arrPlayer
                    })
                    .then((response) => {
                        this.arrPlayer = [];
                        this.$store.state.success = response.data.success;  
                        this.match = 'show';
                    })
                }
            }else {
                this.$store.state.errors = "Le nombre de joueurs requis n'est pas correct : " + this.playerNeeded;
            }
        },
        deleteMember(id, player){
            this.playerList.push(player);
            this.arrPlayer.splice(id,1);
        }
    },
    watch: {
        ladder: function(val) {
            if(val == '5vs5'){
                this.playerNeeded = 5;
            }else if(val == '2vs2'){
                this.playerNeeded = 2;
            }
        }
    },
    created(){
        //Set to curr date/time
        let date = new Date().toISOString();
        this.date = date;
        let token = JSON.parse(this.$store.state.token);
        
        //Get all members
        axios.post(`api/match/getMembers`, {
            token: token[0]
        })
        .then((response)=> {
            this.playerList = response.data;
        })
    }
}
</script>

<style scoped>
img {
    transition: all ease-out 400ms;
    height: 110px;
    width: 90px;
    border-radius: 5px;
}

h1 {
    margin: 0;
    font-size: 1.8rem;
}
h2 {
    font-family: 'Carter One', cursive;
    font-weight: 500;
    text-align: left;
}

h5 {
    font-weight: 500;
}

p {
    font-size: 0.9rem;
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

.match {
    font-size: 1rem;
    color: white;
}

.logo {
   height: 350px; 
   width: 300px;
}

.datetime {
    text-align: center;
    font-size: 0.7rem;
}

.fa-user-plus {
    font-size: 1.3rem;
}

.form-control {
    height: 40px;
}

@media screen and (max-width: 400px) {
    .align-wrap {
        margin-bottom: 0.5rem;
    }
    .ml-2 {
        margin-left: 0!important;
    }
}
</style>