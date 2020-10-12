<template>
  <v-container>
    <v-card class="pa-3">
      <h2 class="black--text">
        Requisição de Consulta 
        #{{id}} - 
        <span class="grey--text">
          {{this.status === null ? "AGUARDANDO CONFIRMAÇÃO" : this.statusName}}
        </span>
      </h2>
    </v-card>

    <v-card class="pa-3 mt-5">
      <h4>Paciente: <span class="grey--text">{{this.patient.name}}</span></h4>
      <h4>Doutor: <span class="grey--text">{{this.doctor.name}}</span></h4>
      <h4>data da requisição: <span class="grey--text">{{this.created_at}}</span></h4>
      <h4 v-if="status === 1">
        data da confirmação: <span class="grey--text">{{this.updated_at}}</span>
      </h4>
      <h4 v-if="status === 0">
        data da rejeição: <span class="grey--text">{{this.updated_at}}</span>
      </h4>
    </v-card>


    <v-card 
      class="pa-3 mt-5" 
      v-if="this.status === 1"
    >
      <h3>Resultados de exames/laudos</h3>
      <v-card 
        class="pa-3 mt-4 mb-4 d-flex"
        v-for="examResult in examResults"
        :key="examResult.id"
        v-on:click="() => openExamFile(examResult)"
      >
        <div>
          <span>{{examResult.file.filename}}</span>
        </div>
        <v-spacer></v-spacer>
        <div>
          <span>{{examResult.createdDate}}</span>
        </div>
      </v-card>
    </v-card>
  </v-container>
</template>

<script>
import { format } from "date-fns";
import api from "../../../services/api";
import fileDownload from '../../../services/file';

export default {
  data: function () {
    return {
      id: null,
      status: null,
      created_at: '',
      updated_at: '',
      statusName: '',
      file: {
        filename: '',
      },
      patient: {
        name: '',
      },
      doctor: {
        name: '',
      },
      examResults: [],
    };
  },

  methods: {
    async openExamFile(examResult) {
      fileDownload(`http://localhost:8000/api/files/${examResult.file.filename}`, "exam.pdf");
    },

    async getExamResult() {
      const response = await api.get(`/attendanceRequests/${this.id}/examResults`); 

      if (response.status === 200) {
        const { data } = response;
        this.examResults = data.map((examResult) => ({ 
          ...examResult,  
          createdDate: format(Date.parse(examResult.created_at), "dd/MM/yyyy"),
          updatedDate: format(Date.parse(examResult.updated_at), "dd/MM/yyyy"),
        }));
      }
    }
  },

  async created() {
    this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: true });
    const { params } = this.$router.app.$route;

    this.id = params.id;
    this.status = params.status;
    this.statusName = this.status === 1 ? 'CONFIRMADO' : 'REJEITADO';
    this.patient = params.patient;
    this.doctor = params.doctor;

    this.created_at = format(Date.parse(params.created_at), "dd/MM/yyyy");
    this.updated_at = format(Date.parse(params.updated_at), "dd/MM/yyyy");

    await this.getExamResult();
  }
}
</script>