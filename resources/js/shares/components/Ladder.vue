<template>
    <div class="ladder mt-4" v-if="!choice">
        <div @click="choice = '5vs5'" class="pointer badge badge-grey d-flex flex-row justify-content-between">
          <h3>5 vs 5</h3>
          <div class="badge bg-pink align-self-center p-2">Ladder Officiel</div>
        </div>

        <div @click="choice = '2vs2'" class="pointer badge badge-grey d-flex flex-row justify-content-between">
          <h3>2 vs 2</h3>
          <div class="badge bg-pink align-self-center p-2">Ladder Officiel</div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            choice: false
        }
    },
    watch: {
        choice(){
            this.$emit('myLadder', this.choice);
        }
}
}
</script>

<style scoped>

</style>