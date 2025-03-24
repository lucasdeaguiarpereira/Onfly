import { createRouter, createWebHistory } from 'vue-router';

// Importando os componentes das páginas
import Dashboard from '../../views/Dashboard.vue';
import Login from '../../views/Login.vue';
import CreateTravelRequest from '../../views/CreateTravelRequest.vue';
import NotFound from '../../views/NotFound.vue';

// Definição das rotas
const routes = [
    { path: '/', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/create-request', component: CreateTravelRequest, meta: { requiresAuth: true } },
    { path: '/login', component: Login },
    { path: '/:pathMatch(.*)*', component: NotFound }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Middleware de autenticação para proteger rotas
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('token'); // Verifica se há um token salvo

    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/login'); // Redireciona para o login se o usuário não estiver autenticado
    } else {
        next(); // Caso contrário, continua a navegação normalmente
    }
});

export default router;
