<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="390"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn 
          width="96%" 
          :color="btnColor"
          v-on="on"
          v-bind="attrs"
        >
          {{btnText}}
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="headline">
          {{title}}
        </v-card-title>
        <v-card-text>{{this.contentText}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            {{cancelText}}
          </v-btn>
          <v-btn
            color="green darken-1 red--text"
            text
            @click="deleteAccount"
          >
            {{confirmText}}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
      }
    },

    methods: {
      deleteAccount() {
        this.$store.dispatch('deleteAccount');
        this.dialog = false;
      }
    },

    props: [
      'contentText', 
      'btnColor', 
      'confirmText', 
      'cancelText', 
      'title', 
      'btnText'
    ],
  }
</script>