<template>
    <div>
        <div v-if="!reglement">
            <h1 class="title">Valorant Slayer Victory</h1>
            <p class="my-4">Vous permet de jouer des matchs avec le meme reglement que des joueurs pros. Votre équipe gagne/perd des point a chaque match et évolue dans le ladder.</p>
            <h2>Qui sera le prochain slayer ?</h2>

            <div class="d-flex justify-content-between">
                <div @click="reglement = !reglement" class="py-2 px-3 mr-1 badge badge-grey">
                    <h1>Règlement</h1>
                </div>
            </div>

            <div class="alert alert-info mt-2">
                <h4>Information</h4>
                <p class="info">Bienvenue, application fonctionnelle avec système de classement par point sur victoire/défaite. Vous pouvez crée/invité des membres dans votre team, voir leurs performances ainsi que celle de votre team. Merci !</p>
            </div>
        </div>

        <div v-if="reglement">
            <h1 class="my-4">Rêgles officiels</h1>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">- Match qui se déroule en 13 manches gagnantes.(pas d'égalité)</li>
                <li class="list-group-item">- Aucune restriction compétences, armes, personnages.</li>
                <li class="list-group-item">- Le sang doit être désactiver.</li>
                <li class="list-group-item">- Les mêmes maps peuvent être jouer par les deux équipes.</li>
                <li class="list-group-item">- Infos supplémentaire a venir !</li>
            </ul>
            <i @click="reglement = !reglement" class="mt-3 pointer fas fa-reply color-red"></i>
        </div>
    </div>

</template>

<script>
export default {
    data(){
        return {
            reglement: false
        }
    }
}
</script>

<style scoped>
h2 {
    font-family: 'Carter One', cursive;
    margin-bottom: 20px;
}

h4 {
    font-size: 1.5rem;
}

p {
    text-align: justify;
}
.title {
    margin-top: 40px;
}

.info {
    text-align: justify;
    font-size: 0.9rem;
}

.badge-grey {
    cursor: pointer;
}

li {
    font-size: 1rem;

}
</style>