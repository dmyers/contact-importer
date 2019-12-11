var VueRouter = require('vue-router').default;

Vue.use(VueRouter);

const routes = [
    {
        path: '/import',
        component: require('./components/ContactImporter.vue').default
    },
    {
        path: '*',
        component: require('./components/PageNotFound.vue').default
    },
    {
        path: '/',
        redirect: '/import'
    }
];

var router = new VueRouter({
    base: '/',
    // mode: 'history',
    mode: 'hash',
    routes: routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'active'
});

module.exports = router;
