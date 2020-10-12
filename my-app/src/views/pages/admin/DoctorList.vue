<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="doctors"
      :items-per-page="5"
      class="elevation-1"
      @click:row="onDoctorClick"
    ></v-data-table>
    <router-link to="/pages/admin/doctors/form">
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
          { text: 'Especialidade', value: 'expertise.name' },
          { text: 'CRM', value: 'crm' },
          { text: 'CPF', value: 'cpf' },
          { text: 'DATA DO CADASTRO', value: 'createdDate' },
        ],
        doctors: [],
      }
    },

    async created() {
      this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: true });

      const response = await api.get('doctors');

      if(response.status === 200) {
        const { data } = response;
        this.doctors = data.map((doctor) => ({
          ...doctor,
          createdDate: format(Date.parse(doctor.created_at), "dd/MM/yyyy"),
          updatedDate: format(Date.parse(doctor.updated_at), "dd/MM/yyyy")
        }));
      }
    },

    methods: {
      onDoctorClick(item) {
        this.$router.push({ name: 'DoctorsForm', params: { ...item } });
      }
    }
  }
</script>