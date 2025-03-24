<template>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">Login</h1>
        <form @submit.prevent="login">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" v-model="email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" id="password" v-model="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return { email: '', password: '' };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        });

        localStorage.setItem('token', response.data.data.token); // Salva o token
        this.$router.push('/'); // Redireciona para a Dashboard
      } catch (error) {
        console.error('Erro no login:', error);
      }
    }
  }
};
</script>
