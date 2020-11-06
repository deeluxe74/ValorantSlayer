<template>
    <div>
        <div class="d-flex flex-column mt-4">
            <div class="badge-grey p-2">
                <div class="d-flex flex-column">
                    <div class="my-1 d-flex flex-row justify-content-around">
                        <img :src="team.logo" alt="logo equipe">
                    </div>
                    <div class="mt-2 d-flex flex-row justify-content-around">
                        <div class="d-flex flex-column">
                            <h2>{{ team.name }}</h2>
                            <h5 class="align-center"><span class="color-green">{{ team.victory }}</span>/<span class="color-blue">{{ team.equal }}</span>/<span class="color-red">{{ team.defeat }}</span></h5>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-around">
                        <div class="d-flex flex-column">
                            <h3>Score :</h3>
                            <h4 class="color-gold">{{ team.score }}</h4>
                        </div>
                    </div>
                    <h4 class="align-center date py-1">Slayers : {{ members.length }}</h4>
                </div>
            </div>
        </div>
        <div class="team1 mt-3">
            <h1 class="align-start">{{ team.name }}</h1>
            <table v-if="loaded" class="table table-striped">
                <tbody>
                    <tr v-for="(member, index) in members" :key="'player' + index" id="forceBg" class="badge-members"> 
                        <td>{{ member.name }}</td>
                        <td>{{ member.roles }}</td>
                        <td class="align-center"><span class="color-green">{{ member.win }}</span>/<span class="color-blue">{{ member.equal == null ? '0' : member.equal }}</span>/<span class="color-red">{{ member.loose == null ? '0' : member.loose }}</span></td>
                    </tr>
                </tbody>
            </table>      
        </div>
    </div>
</template>

<script>
export default {
    props : ['team'],
    data() {
        return {
            loaded: false,
            members: [],
        }
    },
    created(){
        let teamId = this.team.id;
        axios.post(`api/profil/team`, {
                    team_id: teamId
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
}
</script>

<style scoped>
h1 {
    color: black;
    font-size: 1.5rem;
}

h2 {
    color: white;
    font-size: 1.8rem;
    font-weight: 800;
}

h3 {
    font-family: 'Carter One', cursive;
    font-size: 1.2rem;
}

h4 {
    font-weight: 200;
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
    border-radius: 10px;
    height: 120px;
    width: 150px;
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

.color-gold {
    font-weight: 500;
}

.date {
    font-family: 'Carter One', cursive;
    font-weight: 100;
}

.badge-members {
    color: black;
}
</style>