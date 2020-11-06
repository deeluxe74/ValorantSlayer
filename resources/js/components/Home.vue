<template>
  <div class="container logoBg">
    <div class="d-flex flex-column justify-content-center">
      <div class="rules mt-4">
        <h1>4 étapes pour jouer !</h1>
        <table class="table table-striped">
          <tbody>
            <tr id="forcebg"> 
                <td>Crée ton compte</td>
            </tr>
            <tr id="forcebg"> 
                <td>Rejoindre/Crée une team</td>
            </tr>
            <tr id="forcebg"> 
                <td>Lire le rêglement</td>
            </tr>
            <tr id="forcebg"> 
                <td>Accepte ou crée ton match</td>
            </tr>
        </tbody>
      </table>   
    </div>
    <div class="badge bg-pink py-2 px-1">
      Ton équipe sera Slayer <span class="color-gold ">#1</span> ?
    </div>
  </div>
</div>
  
</template>

<script>
export default {

}
</script>

<style scoped>
h1 {
  margin-top: 30px;
  color: rgb(46, 46, 46);
}


ul {
  line-height: 2.5rem;
  text-align: center;
  color: black;
  font-size: 1rem;
  font-weight: 500;
  font-family: 'Montserrat', sans-serif;
}

.table th, .table td {
  border: none;
}

li {
  list-style-type: none;
}

#forcebg {
  background-color: unset;
}

tr {
  text-align: center;
  font-size: 0.9rem;
}

.bg-pink {
  line-height: 1.9rem;
  font-size: 1.5rem;
  color: white;
}

.ladder {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
}

.logoBg {
  background-image: url('../shares/img/opacity.png');
  background-size: contain;
  background-position: bottom;
  background-repeat: no-repeat;
  height: auto;
}
.container {
  height: 80vh;
}
</style>