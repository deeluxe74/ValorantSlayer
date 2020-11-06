<template>
    <div class="fullHeight left">
        <nav-bar></nav-bar>
        <div class="container">
            <get-message :errors="errors" :success="success"></get-message>
            <transition name="swap" mode="out-in">
                <router-view ></router-view>
            </transition>
        </div>
    
        <nav-bottom class="navBottom"></nav-bottom>
    </div>
</template>

<script>
import NavBar from './shares/components/NavBar';
import NavBottom from './shares/components/NavBottom';
import GetMessage from './shares/components/GetMessage';

export default {
    components: {
        NavBar,
        NavBottom,
        GetMessage
    },
    computed: {
        success: function(){
            return this.$store.state.success;
        },
        errors: function(){
            return this.$store.getters.errorsGetter;
        }
    }
}
</script>

<style>
html, body {
    overflow: scroll;
    overflow-x: hidden;
}
::-webkit-scrollbar {
    width: 0px;  /* Remove scrollbar space */
    background: transparent;  /* Optional: just make scrollbar invisible */
}


body {
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
    font-size: 25px;
    background-color: rgb(248, 248, 248);
}

h1 {
    margin: 0;
    color: #E23E49;
    text-align: center;
    font-size: 1.8rem;
    font-family: 'Carter One', cursive;
}

h2 {
    color: black;
    font-size: 1.3rem;
    text-align: center;
    font-family: 'Montserrat', sans-serif;
}

h3 {
    font-size: 2rem;
    font-weight: 700;
}

p {
    font-size: 1rem;
}

a:hover {
    opacity: 0.7;
}

.fullHeight {
    height: 100vh;
    width: 100vw;
}

.container {
    height: auto;
    overflow: auto;
    margin-bottom: 10vh;
}

.navBottom {
    position: fixed;
    bottom: 0px;
}

.router {
    height: 80vh;
}

.color-gold {
    color: #F3C30B !important;
}

.color-green {
    color: #00FF19!important;
}

.color-red {
    color: #CE0000!important;
}

.color-white {
    color: white!important;
}

.color-blue {
    color: #05B6C1!important;
}

.color-pink {
    color: #FF4654;
}

.bg-pink {
    background-color: #FF4654;
}

.badge-grey {
    padding: 0.6rem 1.5rem;
    margin-bottom: 10px;
    color: white;
    background-color: #242424;
    border-radius: 15px;
}

.justify-content-evenly {
    justify-content: space-evenly;
}

.fa-modify {
    font-size: 4rem;
}

.pointer {
    cursor: pointer;
}

.align-start {
    text-align: start;
}

.align-center {
    text-align: center;
}

.align-left {
    text-align: left;
}

.align-end {
    text-align: end;
}

label {
    font-size: 1rem;
    font-weight: 800;
}

.form-group {
    font-size: 1rem;
}

.fa-window-close:hover {
    opacity: 0.7;
}

.badge {
  white-space: unset;
}

.swap-enter-active, .swap-leave-active {
  transition: all 500ms;
}
.swap-enter, .swap-leave-to {
  transform: translateY(-100vh);
}


@media screen and (max-width: 350px) {
    h3 {
        font-size: 1.5rem!important;
    }
}

</style>