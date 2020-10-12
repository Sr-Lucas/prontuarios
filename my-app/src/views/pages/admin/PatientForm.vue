<template>
  <v-form v-model="valid">
    <v-card class="pa-4 mx-3 mt-3">
      <h4>Informações pessoais</h4>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="name"
            :rules="nameRules"
            :counter="40"
            label="Nome"
            filled
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="user.cpf"
            :rules="cpfRules"
            :counter="11"
            label="CPF"
            filled
            required
            :disabled="!!this.patientId"
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="phone"
            :rules="phoneRules"
            label="Telefone/Celular"
            filled
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <h4>Endereço</h4>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.cep"
            :rules="cepRules"
            label="CEP"
            filled
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.city"
            :rules="cityRules"
            label="Cidade"
            filled
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.state"
            :rules="stateRules"
            label="Estado"
            filled
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.street"
            :rules="streetRules"
            label="Rua"
            filled
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.neighborhood"
            :rules="neighborhoodRules"
            label="Bairro"
            filled
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.number"
            :rules="numberRules"
            label="Número"
            filled
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.complement"
            :rules="complementRules"
            label="Complemento"
            filled
            required
          ></v-text-field>
        </v-col>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="address.reference"
            :rules="referenceRules"
            label="Ponto de referência"
            filled
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <h4 v-if="!this.patientId">Acesso ao sistema</h4>
      <v-row v-if="!this.patientId">
        <v-col
          cols="12"
          md="4"
        >
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
        v-on:click="storePatient"
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
      patientId: null,
      name: '',
      phone: '',
      user: {
        id: null,
        cpf: '',
        password: '',
      },
      address: {
        id: null,
        cep: '',
        city: '',
        state: '',
        street: '',
        neighborhood: '',
        number: '',
        complement: '',
        reference: '',
      },
      valid: false,
      cpfRules: [
        v => !!v || 'CPF e obrigatório',
        v => v.length === 11 || 'CPF deve ter 11 caracteres',
      ],
      nameRules: [
        v => !!v || 'Nome é obrigatório',
        v => v.length <= 40 || 'CPF deve ter menos de 40 caracteres',
      ],
      passwordRules: [
        v => !!v || 'Senha é obrigatória',
        v => v >= 6 || 'Senha deve ter pelo menos 6 caracteres'
      ],
      phoneRules: [
        v => !!v || 'Telefone/Celular é obrigatório',
      ],
      cepRules: [
        v => !!v || 'CEP é obrigatório',
      ],
      cityRules: [],
      stateRules: [],
      streetRules: [],
      neighborhoodRules: [],
      numberRules: [],
      complementRules: [],
      referenceRules: [],

      items: []
    }),

    created() {
      this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: true });
      const { params } = this.$router.app.$route;

      if(Object.keys(params).length > 0) {
        this.patientId = params.id;
        this.name = params.name;
        this.user = {...this.user, ...params.user};
        this.phone = params.phone;
        this.address = {...this.addresses, ...params.addresses[0]};
      }
    },

    methods: {
      async storePatient() {
        const isUserFildFilled = this.user.cpf && (this.user.id || this.user.password);

        const isPatientFildFilled = this.name && this.phone;

        const isPatientAddressFieldFilled = this.address.city && this.address.state && this.address.street && 
          this.address.neighborhood && this.address.number && this.address.complement && this.address.reference;


        if(!isUserFildFilled || !isPatientFildFilled || !isPatientAddressFieldFilled) {
          alert('Existem campos não preenchidos');
          return;
        }

        let responsePatient;

        const patient = {
          name: this.name,
          cpf: this.user.cpf,
          password: this.user.password,
          phone: this.phone,
        };

        if(!this.patientId) {
          responsePatient = await api.post('/patients', patient);
        } else {
          responsePatient = await api.put(`/patients/${this.patientId}`, patient);
        }
        
        if(responsePatient.status === 200) {
          // const { id } = responsePatient.data;

          let responseAddress;

          if(!this.address.id) {
            const patient = responsePatient.data;
            responseAddress = await api.post(`/patients/${patient.id}/addresses`, this.address);
          } else {
            responseAddress = await api.put(`/addresses/${this.address.id}`, this.address);
          }

          if(responseAddress.status === 200) {
            this.$router.go(-1);
          } else {
            alert('Houve um erro ao salvar o endereço!');
          }


          return;
        }

        alert('Houve um erro ao salvar o paciente!');
      },
    }
  }
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