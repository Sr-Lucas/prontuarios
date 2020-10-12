<template>
  <v-container id="dashboard">
    <v-row justify="center">
      <v-col md="5" xl="3" sm="6">
        <v-card
          class="d-flex flex-column pa-5 card-admin-dashboard"
          max-width="400"
          min-height="320"
          max-height="350"
        >
          <img
            src="../../../assets/doctor.jpg"
            alt="doutores"
            width="70%"
            class="align-self-center ma-5"
          />
          <v-spacer></v-spacer>
          <router-link to="/pages/admin/doctors" width="100%">
            <v-btn width="100%" color="#714cfe">DOUTORES</v-btn>
          </router-link>
        </v-card>
      </v-col>
      <v-col md="5" xl="3" sm="6">
        <v-card
          class="d-flex flex-column pa-5 card-admin-dashboard"
          max-width="400"
          min-height="320"
          max-height="350"
        >
          <img
            src="../../../assets/patient.jpg"
            alt="doutores"
            width="70%"
            class="align-self-center ma-5"
          />
          <v-spacer></v-spacer>
          <router-link to="/pages/admin/patients" width="100%">
            <v-btn width="100%" color="#714cfe">PACIENTES</v-btn>
          </router-link>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  created() {
    this.$store.dispatch('SET_ARROW_BACK_VISIBILITY', { visibility: false });
  }
};
</script>

<style lang="sass">
.card-admin-dashboard
  height: calc(100vh - 180px)
</style>
