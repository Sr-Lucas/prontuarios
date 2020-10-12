<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="patients"
      :items-per-page="5"
      class="elevation-1"
      @click:row="onPatientClick"
    ></v-data-table>
    <router-link to="/pages/admin/patients/form">
      <v-btn
      class="mx-2"
      fab
      dark
      color="indigo"
      fixed
      bottom
      right
    >
      <v-icon dark>
        mdi-plus
      </v-icon>
    </v-btn>
    </router-link>
  </v-container>
</template>

<script>
  import { mapMutations } from 'vuex';
  import { format } from "date-fns";
  import api from '../../../services/api';

  export default {
    data () {
      return {
        headers: [
          {
            text: 'Nome',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          { text: 'CPF', value: 'cpf' },
          { text: 'DATA DO CADASTRO', value: 'createdDate' },
        ],
        patients: [
          
        ],
      }
    },

    async created() {
      this.SET_ARROW_BACK_VISIBILITY({ visibility: true });

      const response = await api.get('patients');

      if(response.status === 200) {
        const { data } = response;
        this.patients = data.map((patient) => ({
          ...patient,
          createdDate: format(Date.parse(patient.created_at), "dd/MM/yyyy"),
          updatedDate: format(Date.parse(patient.updated_at), "dd/MM/yyyy")
        }));
      }
    },
    methods: {
      ...mapMutations([
        'SET_ARROW_BACK_VISIBILITY',
      ]),
      onPatientClick(item) {
        this.$router.push({ name: 'PatientsForm', params: { ...item } });
      }
    }
  }
</script>