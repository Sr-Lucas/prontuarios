<template>
  <v-container>
    <h2 class="mb-5 mt-4">Requisiçoes de atendimento enviadas:</h2>

    <v-card 
      class="pa-5 request-card mb-3" 
      v-for="attendance in attendances" 
      :key="attendance.id"
      v-on:click="() => openAttendanceRequest(attendance)"
    >
      <div class="d-flex">
        <span class="d-block">{{attendance.doctor.name}} - </span>
        <span>{{
          attendance.status === null 
            ? 'AGUARDANDO CONFIRMAÇÃO' 
            :  attendance.status === 1 ? 'CONFIRMADO' : 'REJEITADO'
        }}</span>
      </div>

      <div class="align-self-center request-actions">
        <span class="d-block">{{attendance.updatedDate}}</span>
      </div>
    </v-card>

    <router-link to="/pages/patient/doctors">
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
import { format } from 'date-fns';
import api from "../../../services/api";

export default {
  data: function () {
    return {
      color: '#9a9a9a',
      attendances: [],
    }
  },

  methods: {
    openAttendanceRequest(attendance) {
      this.$router.push({ name: 'PatientRequestForm', params: { ...attendance } });
    },

    async getAllAttendanceRequests() {
      const response = await api.get('attendanceRequests');

      if (response.status === 200) {
        const { data } = response;
        this.attendances = data;
  
        this.attendances = this.attendances.map((attendance) => ({ 
          ...attendance, 
          createdDate: format(Date.parse(attendance.created_at), "dd/MM/yyyy"),
          updatedDate: format(Date.parse(attendance.updated_at), "dd/MM/yyyy"),
        }));

        console.log(this.attendances);
      }
    }
  },

  async created() {
    this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: false });
    await this.getAllAttendanceRequests();
  }
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