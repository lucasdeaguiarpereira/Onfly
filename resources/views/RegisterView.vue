<template>
  <div class="register-container">
    <div class="card register-card shadow-lg">
      <div class="card-body">
        <h2 class="text-center mb-4">Cadastrar Usuário</h2>
        
        <!-- Mensagem de sucesso -->
        <div v-if="successMessage" class="alert alert-success mb-3" role="alert">
          {{ successMessage }}
        </div>

        <!-- Mensagem de erro -->
        <div v-if="errorMessage" class="alert alert-danger mb-3" role="alert">
          {{ errorMessage }}
        </div>

        <form @submit.prevent="register">
          <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" v-model="name" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" v-model="email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" id="password" v-model="password" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirme a Senha</label>
            <input type="password" id="password_confirmation" v-model="password_confirmation" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return { 
      name: "", 
      email: "", 
      password: "", 
      password_confirmation: "",
      successMessage: "",  
      errorMessage: ""     
    };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post("/api/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });

        // Mensagem de sucesso
        this.successMessage = "Usuário cadastrado com sucesso! Faça login para continuar.";

        // Limpa a mensagem após 5 segundos
        setTimeout(() => {
          this.successMessage = "";
        }, 5000);

        // Redireciona para login após sucesso
        // this.$router.push("/login");
      } catch (error) {
        // Lidar com o erro e exibir a mensagem de erro
        if (error.response && error.response.data && error.response.data.message) {
          this.errorMessage = error.response.data.message; // Exibe a mensagem de erro vinda do backend
        } else if (error.password){
          this.errorMessage = error.password; // Exibe a mensagem de erro vinda do backend
        }else{
          this.errorMessage = "Ocorreu um erro. Tente novamente."; // Mensagem padrão de erro

        }

        // Limpa a mensagem de erro após 5 segundos
        setTimeout(() => {
          this.errorMessage = "";
        }, 5000);
      }
    },
  },
};
</script>

<style scoped>
/* Centraliza o card na tela */
.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

/* Estiliza o card */
.register-card {
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

/* Estilo para a mensagem de sucesso */
.alert-success {
  font-size: 1.2rem;
  font-weight: 500;
}

/* Estilo para a mensagem de erro */
.alert-danger {
  font-size: 1.2rem;
  font-weight: 500;
}
</style>
