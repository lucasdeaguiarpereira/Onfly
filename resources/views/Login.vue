<template>
  <div class="login-container">
    <div class="card login-card shadow-lg">
      <div class="card-body">
        <h2 class="text-center mb-4">Login</h2>
        <form @submit.prevent="login">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" v-model="email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" id="password" v-model="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <p class="text-center mt-3">
          Ainda não tem uma conta? 
          <router-link to="/register">Cadastre-se aqui</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return { email: "", password: "" };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post("/api/login", {
          email: this.email,
          password: this.password,
        });
        
        const token = response.data.data.token;

        // Salvar o token no localStorage para uso em futuras requisições
        localStorage.setItem("token", token);

        // Definir o token como padrão no Axios
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        // Redirecionar para a página protegida
        this.$router.push("/");
              
      } catch (error) {
        console.error("Erro no login:", error);
      }
    },
  },
};
</script>

<style scoped>
/* Centraliza o card na tela */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

/* Estiliza o card */
.login-card {
  width: 100%;
  max-width: 400px;
  padding: 20px;
  border-radius: 10px;
  background: white;
}

/* Sombra suave */
.shadow-lg {
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
</style>
