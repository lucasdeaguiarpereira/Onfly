<template>
    <div class="not-found">
      <h1>404 - Página Não Encontrada</h1>
      <p>A página que você está tentando acessar não existe.</p>
      <router-link to="/">Voltar para o Dashboard</router-link>
    </div>
</template>
  
<script>
  export default {
    name: "NotFound",
  };
</script>
  
<style scoped>
  .not-found {
    text-align: center;
    margin-top: 50px;
  }
  h1 {
    color: red;
  }
</style>
  