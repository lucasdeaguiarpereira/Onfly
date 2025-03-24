<template>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">Dashboard de Pedidos de Viagem</h1>

        <!-- Div para exibir mensagens -->
        <div v-if="mensagem.texto" :class="`alert alert-${mensagem.tipo} text-center`">
          {{ mensagem.texto }}
        </div>

        <div class="mb-3">
          <label for="filterStatus" class="form-label">Filtrar por Status</label>
          <select v-model="filterStatus" id="filterStatus" class="form-select" @change="fetchData">
            <option value="">Todos</option>
            <option value="aprovado">Aprovado</option>
            <option value="cancelado">Cancelado</option>
            <option value="solicitado">Solicitado</option>
          </select>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr class="text-center">
          <th>ID</th>
          <th>Nome Solicitante</th>
          <th>Destino</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="pedido in pedidos" :key="pedido.id" class="text-center" style="vertical-align: middle;">
          <td>{{ pedido.id }}</td>
          <td>{{ pedido.nome_solicitante }}</td>
          <td>{{ pedido.destino }}</td>
          <td>{{ pedido.status }}</td>
          <td style="display: flex; gap: 1rem;">
            <button style="width: 50%;" class="btn btn-success" @click="atualizarStatus(pedido.id, 'aprovado')">
              Aprovar
            </button>
            <button style="width: 50%;" class="btn btn-danger" @click="atualizarStatus(pedido.id, 'cancelado')">
              Cancelar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
  
<script>
import axios from 'axios';

export default {
  data() {
    return {
      pedidos: [],
      filterStatus: "",
      mensagem: { texto: "", tipo: "" }, // Para armazenar mensagens de sucesso ou erro
    };
  },
  methods: {
    async fetchData() {
      try {
        let url = "/api/travel-requests";
        
        if (this.filterStatus) {
          url += `?status=${this.filterStatus}`;
        }

        const response = await axios.get(url);
        this.pedidos = response.data;
      } catch (error) {
        console.error("Erro ao buscar pedidos:", error);
      }
    },
    async atualizarStatus(id, status) {
      try {
        const response = await axios.put(`/api/travel-requests/${id}/status`, { status });

        // Exibir mensagem de sucesso
        this.definirMensagem("Status atualizado com sucesso!", "success");

        this.fetchData();
      } catch (error) {
        console.error("Erro ao atualizar status:", error);

        // Se houver erro, mostrar mensagem com a resposta da API
        const mensagemErro = error.response?.data?.error || "Ocorreu um erro inesperado.";
        this.definirMensagem(mensagemErro, "danger");
      }
    },
    definirMensagem(texto, tipo) {
      this.mensagem = { texto, tipo };

      // Remover mensagem após 5 segundos
      setTimeout(() => {
        this.mensagem.texto = "";
      }, 5000);
    }
  },
  mounted() {
    this.fetchData();
  }
};
</script>
