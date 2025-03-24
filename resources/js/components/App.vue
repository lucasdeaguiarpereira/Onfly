<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <router-link class="navbar-brand" to="/">Pedidos de Viagem</router-link>

      <!-- Botão do menu responsivo -->
      <button class="navbar-toggler" type="button" @click="toggleMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu responsivo -->
      <div class="collapse navbar-collapse" :class="{ show: isMenuOpen }" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/" @click="closeMenu">Dashboard</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/create-request" @click="closeMenu">Criar Pedido</router-link>
          </li>
          <li v-if="!isAuthenticated" class="nav-item">
            <router-link class="nav-link" to="/login" @click="closeMenu">Login</router-link>
          </li>
          <li v-if="isAuthenticated" class="nav-item">
            <a href="#" class="nav-link text-danger" @click.prevent="logout">Sair</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
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
    const isMenuOpen = ref(false);

    const toggleMenu = () => {
      isMenuOpen.value = !isMenuOpen.value;
    };

    const closeMenu = () => {
      isMenuOpen.value = false; // Fecha o menu ao clicar em um link
    };

    const logout = (event) => {
      event.preventDefault();
      localStorage.removeItem("token");
      isAuthenticated.value = false;
      closeMenu(); // Fecha o menu ao sair
      router.push("/login");
    };

    watchEffect(() => {
      isAuthenticated.value = !!localStorage.getItem("token");
    });

    return { isAuthenticated, logout, isMenuOpen, toggleMenu, closeMenu };
  },
};
</script>

<style>
/* Corrige o bug de exibição do menu */
.collapse:not(.show) {
  display: none;
}
</style>
