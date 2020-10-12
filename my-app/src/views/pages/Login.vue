<template>
  <v-container id="login" class="d-flex justify-center">
    <div class="d-flex flex-column login-container">
      <img
        src="../../assets/acessar.png"
        alt="acessar"
        width="60%"
        class="align-self-center ma-5"
      />

      <v-text-field
        class="mt-6"
        v-model="cpf"
        :rules="[rules.cpf, rules.required]"
        :counter="11"
        label="CPF"
        filled
        required
      ></v-text-field>

      <v-text-field
        :value="password"
        label="Senha"
        filled
        :append-icon="value ? 'mdi-eye' : 'mdi-eye-off'"
        @click:append="() => (value = !value)"
        :type="value ? 'password' : 'text'"
        :rules="[rules.password, rules.required]"
        @input="_=>password=_"
      ></v-text-field>

      <v-btn
        class="primary mt-5"
        rouded
        v-on:click="login"
      >
      ENTRAR
      </v-btn>
    </div>
  </v-container>
</template>

<script>
  export default {
    data: function() {
      return {
        cpf: '',
        password: '',
        valid: true,
        value: true,
        rules: {
        required: value => !!value || "obrigatório",
        cpf: value => value.length === 11 || "CPF possui 11 caractéres",
        password: value => {
          return (
            value.length >= 6 ||
            "Mínimo de 6 caracteres"
          );
        }
      }
      };
    },

    created() {
      const token = localStorage.getItem('protuario_token');
      if(token) {
        this.$router.push('/pages/admin/dashboard');
      }
    },

    methods: {
      login() {
        const cpf = this.cpf;
        const password = this.password;
        this.$store.dispatch('login', { cpf, password });
      }
    }
  }
</script>

<style>  

  .login-container {
    max-width: 400px;
  }

</style>


