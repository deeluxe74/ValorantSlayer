import vueRouter from 'vue-router';
import Home from './components/Home';
import Info from './components/Info';
import Score from './components/Score';
import Match from './components/Match';
import Connexion from './components/profil/Connexion';
import SignUp from './components/profil/SignUp';
import PleaseSign from './components/PleaseSign';
import Profil from './components/profil/Profil';
import Fiche from './shares/components/Fiche';


export const router = new vueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/info',
            name: 'info',
            component: Info
        },
        {
            path: '/profil',
            name: 'profil',
            component: Profil,
            beforeEnter: (to, from, next) => {
                const store = router.app.$store;
                
                if(store.state.token == null){               
                    next(false);
                    window.location.href= '/PleaseSign';
                }else {
                    next();
                }
            }
        },
        {
            path: '/score',
            name: 'score',
            component: Score,
            beforeEnter: (to, from, next) => {
                const store = router.app.$store;
                
                if(store.state.token == null){               
                    next(false);
                    window.location.href= '/PleaseSign';
                }else {
                    next();
                }
            }
        },
        {
            path: '/match',
            name: 'match',
            component: Match,
            beforeEnter: (to, from, next) => {
                const store = router.app.$store;
                
                if(store.state.token == null){               
                    next(false);
                    window.location.href= '/PleaseSign';
                }else {
                    next();
                }
            }
        }, 
        {
            path: '/fiche',
            name: 'matchFiche',
            component: Fiche,
            props: true,
            beforeEnter: (to, from, next) => {
                const store = router.app.$store;
                
                if(store.state.token == null){               
                    next(false);
                    window.location.href= '/PleaseSign';
                }else {
                    next();
                }
            }
        }, 
        {
            path: '/connexion',
            name: 'connexion',
            component: Connexion,
            beforeEnter: (to, from, next) => {
                const store = router.app.$store;
                
                if(store.state.token == null){               
                    next();
                }else {
                    next(false);
                }
            }
        },
        {
            path: '/signUp',
            name: 'signUp',
            component: SignUp,
            beforeEnter: (to, from, next) => {
                const store = router.app.$store;

                if(store.state.token == null){               
                    next();
                }else {
                    next(false);
                }
            }
        },
        {
            path: '/pleaseSign',
            name: 'pleaseSign',
            component: PleaseSign
        },
    ]
});