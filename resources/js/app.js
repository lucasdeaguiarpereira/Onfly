import './bootstrap';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './src/router.js';

import axios from 'axios';

// Configuração global do Axios
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
axios.defaults.withCredentials = true;

const app = createApp(App);
app.use(router);
app.mount('#app');

export default axios;