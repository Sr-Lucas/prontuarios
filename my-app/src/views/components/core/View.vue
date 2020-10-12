<template>
  <v-main>
    <router-view />
    
  </v-main>
</template>

<script>
  export default {
    name: 'DashboardCoreView',

    components: {
      // DashboardCoreFooter: () => import('./Footer'),
    },
  }
</script>

<style lang="sass">
  .v-main
    margin-top: 50px
</style>
