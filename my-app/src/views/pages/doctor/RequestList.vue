<template>
  <v-container>
    <h2 class="mb-5 mt-4">Lista de requisições de atendimento:</h2>

    <v-card 
      class="pa-5 request-card mb-3" 
      v-for="attendance in attendances" 
      :key="attendance.id" 
      v-on:click="() => onClickRequestCard(attendance)"
    >
      <div>
        <span class="d-block">{{attendance.patient.name}}</span>
        <span class="d-block">{{attendance.createdDate}}</span>
      </div>

      <div class="request-actions align-self-center" v-if="attendance.status === null">
        <v-btn class="mr-3" color="green" v-on:click="() => onAcceptAttendanceRequest(attendance)">
          <v-icon>mdi-check</v-icon>
        </v-btn>
        <v-btn color="red" v-on:click="() => onRejectAttendanceRequest(attendance)">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </div>
      <div v-if="attendance.status !== null" class="align-self-center">
        <span :class="attendance.status === 1 ? 'green--text' : 'red--text'" >
          {{attendance.status === 1 ? 'ACEITO' : 'REJEITADO' }}
        </span>
      </div>
    </v-card>
  </v-container>
</template>

<script>
import api from "../../../services/api";
import { format } from 'date-fns';

export default {
  data: function () {
    return {
      attendances: []
    }
  },
  methods: {
    onClickRequestCard(attendance) {
      this.$router.push({ name: 'DoctorRequestForm', params: { ...attendance } });
    },

    async onAcceptAttendanceRequest(attendance) {
      await api.put(`attendanceRequests/${attendance.id}`, {
        status: true,
      });

      await this.getAllAttendanceRequests();
    },

    async onRejectAttendanceRequest(attendance) {
      await api.put(`attendanceRequests/${attendance.id}`, {
        status: false,
      });

      await this.getAllAttendanceRequests();
    },

    async getAllAttendanceRequests() {
      const response = await api.get('attendanceRequests');

      if (response.status === 200) {
        const { data } = response;
        this.attendances = data.map((attendance) => ({
          ...attendance,
          createdDate: format(Date.parse(attendance.created_at), "dd/MM/yyyy"),
          updatedDate: format(Date.parse(attendance.updated_at), "dd/MM/yyyy"),
        }));
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