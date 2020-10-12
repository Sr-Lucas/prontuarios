<template>
  <div class="user-page-wrapper">
    <v-card class="pa-3">
      <h2 class="black--text">
        Dados do usuário
      </h2>
    </v-card>

    <v-card class="pa-3 mt-5">
      <h3 class="mb-2">Informações do usuário:</h3>
      <h4 class="mb-1">Nome: <span class="grey--text">{{this.user.patient.name}}</span></h4>
      <h4 class="mb-1">Telefone: <span class="grey--text">{{this.user.patient.phone}}</span></h4>
      <h4 class="mb-1">CPF: <span class="grey--text">{{this.user.cpf}}</span></h4>
      <h3 class="mb-2 mt-2">Endereço:</h3>
      <h4 class="mb-1">CEP: <span class="grey--text">{{this.user.patient.addresses[0].cep}}</span></h4>
      <h4 class="mb-1">Cidade: <span class="grey--text">{{this.user.patient.addresses[0].city}}</span></h4>
      <h4 class="mb-1">Estado: <span class="grey--text">{{this.user.patient.addresses[0].state}}</span></h4>
      <h4 class="mb-1">Bairro: <span class="grey--text">{{this.user.patient.addresses[0].neighborhood}}</span></h4>
      <h4 class="mb-1">Rua: <span class="grey--text">{{this.user.patient.addresses[0].street}}</span></h4>
      <h4 class="mb-1">Número: <span class="grey--text">{{this.user.patient.addresses[0].number}}</span></h4>
      <h4 class="mb-1">Complemento: <span class="grey--text">{{this.user.patient.addresses[0].complement}}</span></h4>
      <h4 class="mb-1">Ponto de Referência: <span class="grey--text">{{this.user.patient.addresses[0].reference}}</span></h4>
    </v-card>

    <v-card class="pa-3 mt-5">
      <v-btn width="100%" color="warning" class="mb-3">
        LOGOUT
      </v-btn>
      <ConfirmationDialog
        contentText="Ao confirmar sua conta será desativada e os dados serão anonimizados. Essa ação nao pode ser desfeita!"
        btnColor="red"
        confirmText="EXCLUIR CONTA"
        cancelText ="CANCELAR"
        title="Tem certeza que deseja excuir sua conta?"
        btnText="EXCUIR CONTA"
      />
    </v-card>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import ConfirmationDialog from '../../components/core/ConfirmationDialog';

export default {
  data: function() {
    return {
      
    };
  },
  computed: {
    ...mapState([
      'user'
    ]),
  },
  components: {
    ConfirmationDialog,
  },
  created() {
    this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: true });
  }
}
</script>

<style>
  .user-page-wrapper {
    margin: 1.5rem auto;
    width: max(40%, 400px);
  }

  @media (max-width: 600px) {
    .user-page-wrapper {
      margin-top: 1.5rem;
      width: 100%;
    }
  }
</style>