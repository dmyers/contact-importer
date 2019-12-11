var VueRouter = require('vue-router').default;

Vue.use(VueRouter);

const routes = [
    {
        path: '/campaigns/new',
        component: require('./components/CampaignForm.vue').default
    },
    {
        path: '/campaigns',
        component: require('./components/CampaignManager.vue').default
    },
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
