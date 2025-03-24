<template>
    <div>
      <nav>
        <router-link to="/">Dashboard</router-link> |
        <router-link to="/create-request">Criar Pedido</router-link> |
        <router-link v-if="!isAuthenticated" to="/login">Login</router-link>
        <button v-if="isAuthenticated" @click="logout">Sair</button>
      </nav>
  
      <router-view />
    </div>
</template>
  
<script>
  import { ref, watchEffect } from "vue";
  import { useRouter } from "vue-router";
  
  export default {
    setup() {
      const router = useRouter();
      const isAuthenticated = ref(!!localStorage.getItem("token"));
  
      const logout = () => {
        localStorage.removeItem("token");
        isAuthenticated.value = false;
        router.push("/login");
      };
  
      watchEffect(() => {
        isAuthenticated.value = !!localStorage.getItem("token");
      });
  
      return { isAuthenticated, logout };
    },
  };
</script>
  