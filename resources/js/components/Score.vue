<template>
    <div class="d-flex flex-column justify-content-start">
        <div>
            <h1 v-if="!choice" class="mt-4">Les Scores</h1>
            <router-link to="/"><i class="fas fa-reply color-red "></i></router-link>
            <div v-if="!choice" @click="choice = true" class="mt-4 pointer badge badge-grey d-flex flex-row justify-content-between">
                <h3>Slayer</h3>
                <div class="badge bg-pink align-self-center p-2">Ladder Officiel</div>
            </div>
            <div class="choice" v-if="choice">
                <table-score :choice="choice"></table-score>
            </div>
        </div>
        <img class="align-self-center mt-5" src="../shares/img/nav/glaiveblack100.png" alt="Logo first glaive">
    </div>
</template>

<script>
import Ladder from '../shares/components/Ladder';
import TableScore from '../shares/components/TableScore';

export default {
    components: {
        Ladder,
        TableScore
    },
    data(){
        return {
            choice: false
        }
    },
    methods: {
        myChoice(){
            this.choice = true;
        }
    }
}
</script>

<style scoped>
img {
    opacity: 0.8;
    width: 200px;
    height: 250px;
}

th {
    font-size: 1.1rem;
    border: none;
}

td {
    font-size: 0.9rem; 
}

.line {
    font-weight: 700;   
}

.choice {
    text-align: center;
    margin-top: 40px;
}

.rank {
    font-size: 2rem;
}
</style>