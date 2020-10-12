<template>
  <v-app>
    <v-app-bar />
    <main-view />
  </v-app>
</template>

<script>
  export default {
    name: 'DashboardIndex',

    components: {
      VAppBar: () => import('../components/AppBar'),
      MainView: () => import('./components/core/View'),
    },

    data: () => ({
      expandOnHover: false,
    }),

    methods: {
      shouldRedirectToLogin() {
        const token = localStorage.getItem('prontuario_token');
        if(!token) {
          this.$router.push('/');
        }
      }
    },

    created() {
      this.shouldRedirectToLogin();
    },

    updated() {
      this.shouldRedirectToLogin();
    }
  }
</script>