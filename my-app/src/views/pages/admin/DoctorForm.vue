<template>
  <v-form v-model="valid">
    <v-card class="pa-4 mx-3 mt-3">
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field
            v-model="name"
            :rules="nameRules"
            :counter="40"
            label="Nome"
            filled
            required
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="user.cpf"
            :rules="cpfRules"
            :counter="11"
            label="CPF"
            filled
            required
            :disabled="!!this.doctorId"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
          <v-text-field
            v-model="crm"
            :rules="crmRules"
            label="CRM"
            filled
            required
          ></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="4">
          <v-select
            v-model="expertise_id"
            :items="expertises"
            item-text="name"
            item-value="id"
            label="ESPECIALIDADE"
            filled
          >
          </v-select>
        </v-col>

        <v-col cols="12" md="4" v-if="!this.doctorId">
          <v-text-field
            v-model="user.password"
            :rules="passwordRules"
            label="PRIMEIRA SENHA"
            filled
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-btn
        class="mx-2"
        rounded
        dark
        color="indigo"
        fixed
        bottom
        right
        v-on:click="storeDoctor"
      >
        <v-icon dark>
          mdi-content-save
        </v-icon>
        <span class="mx-2">Salvar</span>
      </v-btn>
    </v-card>
  </v-form>
</template>

<script>
import api from '../../../services/api';

export default {
  data: () => ({
    doctorId: null,
    user: {
      cpf: '',
      password: '',
    },
    valid: false,
    name: '',
    crm: '',
    cpfRules: [
      v => !!v || 'CPF e obrigatório',
      v => v.length === 11 || 'CPF deve ter 11 caracteres',
    ],
    nameRules: [
      v => !!v || 'Nome é obrigatório',
      v => v.length <= 40 || 'Nome deve ter menos de 40 caracteres',
    ],
    crmRules: [v => !!v || 'CRM é obrigatório'],
    passwordRules: [
      v => !!v || 'Senha é obrigatória',
      v => v.length >= 6 || 'Senha deve ter pelo menos 6 caracteres',
    ],

    expertise_id: null,
    expertises: [],
  }),

  async created() {
    this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: true });
    const { params } = this.$router.app.$route;

    if (Object.keys(params).length > 0) {
      this.doctorId = params.id;
      this.name = params.name;
      this.user = params.user;
      this.crm = params.crm;
      this.expertise_id = params.expertise.id;
    }

    const response = await api.get('expertises');

    if (response.status === 200) {
      this.expertises = response.data;
    }
  },

  methods: {
    async storeDoctor() {
      if (
        !(
          this.name
          && (this.doctorId || this.user.cpf)
          && this.crm
          && this.expertise_id
          && (this.doctorId || this.user.password)
        )
      ) {
        alert('Existem campos não preenchidos');
        return;
      }

      let response;

      const doctor = {
        name: this.name,
        cpf: this.user.cpf,
        crm: this.crm,
        password: this.user.password,
        expertise_id: this.expertise_id,
      };

      try {
        if (!this.doctorId) {
          response = await api.post('doctors', doctor);
        } else {
          response = await api.put(`doctors/${this.doctorId}`, doctor);
        }

        if (response.status === 200) {
          this.$router.go(-1);
        }
      } catch(ex) {
        alert('Erro ao criar doutro. Verifique o campo de CPF. (ele pode já existir no banco)');
      }
    },
  },
};
</script>
<style lang="sass">
.toastSuccess
  background-color: #03dac5 !important
  padding: 10px
  color: #ffff

.toastError
  background-color: #f44336 !important
  padding: 10px
  color: #ffff
</style>
