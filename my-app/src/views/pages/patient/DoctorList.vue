<template>
  <v-container>
    <h2 class="mb-5 mt-4">Lista de doutores</h2>

    <v-card class="pa-5 request-card mb-3" v-for="doctor in doctors" :key="doctor.id">
      <div>
        <span class="d-block">{{doctor.name}}</span>
        <span class="d-block">Especialidade: {{doctor.expertise.name}}</span>
      </div>

      <div class="request-actions align-self-center">
        <v-btn color="#714cfe" v-on:click="() => sendAttendanceRequest(doctor.id)">
          <v-icon class="mr-2">mdi-message-plus</v-icon>
          <span>Solicitar Consulta</span>
        </v-btn>
      </div>
    </v-card>
  </v-container>
</template>

<script>
  import api from '../../../services/api';

  export default {
    data: function () {
      return {
        doctors: []
      }
    },

    methods: {
      async getDoctors() {
        const response = await api.get('doctors');
        
        if (response.status === 200) {
          const { data } = response;
          this.doctors = data;
        }
      },

      async sendAttendanceRequest(doctor_id) {
        const response = await api.post(`/doctors/${doctor_id}/attendanceRequests`);
        if(response.status === 200) {
          if(response.data.error) {
            return alert(response.data.message);
          }
          this.$router.go(-1);
        }
      }
    },

    async created() {
      this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: true });
      await this.getDoctors();
    },
  }
</script>

<style>
  .request-card {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .request-actions {
    display: flex;
    flex-direction: row;
  }
</style>