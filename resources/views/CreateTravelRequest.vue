<template>
  <div>
    <!-- Botão para abrir o modal -->
    <div class="row text-center">
      <div class="col-md-12">
        <h1>Criar Pedidos</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRequestModal">
          Criar Pedido
        </button>
      </div>
    </div>
     
    <!-- Modal -->
    <div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createRequestModalLabel">Criar Pedido de Viagem</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <label for="nomeSolicitante" class="form-label">Nome Solicitante</label>
                <input type="text" id="nomeSolicitante" class="form-control" v-model="nome_solicitante" required />
              </div>
              <div class="mb-3">
                <label for="destino" class="form-label">Destino</label>
                <input type="text" id="destino" class="form-control" v-model="destino" required />
              </div>
              <div class="mb-3">
                <label for="dataIda" class="form-label">Data de Ida</label>
                <input type="date" id="dataIda" class="form-control" v-model="data_ida" required />
              </div>
              <div class="mb-3">
                <label for="dataVolta" class="form-label">Data de Volta</label>
                <input type="date" id="dataVolta" class="form-control" v-model="data_volta" required />
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" class="form-select" v-model="status" required>
                  <option value="pendente">Pendente</option>
                  <option value="aprovado">Aprovado</option>
                  <option value="cancelado">Cancelado</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <p v-if="mensagem">{{ mensagem }}</p>

</template>
  
<script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        nome_solicitante: '',
        destino: '',
        data_ida: '',
        data_volta: '',
        mensagem: ''
      };
    },
    methods: {
      async submitForm() {
        try {
          await axios.post('/api/travel-requests', {
            nome_solicitante: this.nome_solicitante,
            destino: this.destino,
            data_ida: this.data_ida,
            data_volta: this.data_volta,
          });
          this.mensagem = 'Pedido criado com sucesso!';
        } catch (error) {
          this.mensagem = 'Erro ao criar pedido.';
        }
      }
    }
  };
</script>
  