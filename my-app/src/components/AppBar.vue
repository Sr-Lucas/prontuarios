<template>
  <v-app-bar
    id="app-bar"
    absolute
    color="#714cfe"
    height="50"
    v-if="isAppBarVisible"
  >
    <div class="d-flex flex-row pa-1 appbar-wrapper">
      <div>
        <v-btn 
          v-on:click="() => this.$router.go(-1)" 
          v-if="isBackButtonVisible" 
          text 
          class="justify-end"
        >
          <v-icon color="#ffff">mdi-arrow-left</v-icon>
        </v-btn>
        <v-btn 
          v-on:click="openAccountInfo" 
          text
          class="justify-end"
        >
          <v-icon color="#ffff">mdi-account</v-icon>
        </v-btn>
      </div>
      <v-btn text v-on:click="logout">
        <v-icon class="mr-2" color="#ffff">mdi-logout</v-icon>
        <span style="color: #ffff">SAIR</span>
      </v-btn>
    </div>
  </v-app-bar>
</template>

<script>
  import { mapState } from 'vuex';

  export default {
    computed: {
      ...mapState([
        'user',
        'isAppBarVisible',
        'isBackButtonVisible',
      ]),
    },

    methods: {
      openAccountInfo() {
        console.log(this.user);
        this.$router.push(`/pages/${this.user.user_type}/userPage`);
      },
      logout() {
        this.$store.dispatch('logout');
      }
    }
  }
</script>

<style>
  .appbar-wrapper {
    width: 100%;
    justify-content: space-between;
  }
</style>