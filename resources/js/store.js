import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: () => ({
      errors: false,
      success: false,
      token: localStorage.getItem('user-token')
    }),
    computed: {
      token: function(){
        return localStorage.getItem('user-token');
      }
    },
    getters: {
      errorsGetter: state => {
        state.success = false;
        return state.errors;
      },
      successGetter: state => {
        state.errors = false;
        return state.success;
      }
    }

})