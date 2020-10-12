import Vue from 'vue';
import Vuex from 'vuex';
import api from './services/api';

import router from './router';

Vue.use(Vuex);

function redirects(user_type) {
  switch (user_type) {
    case 'administrator':
      return router.push('/pages/admin/dashboard');
    case 'doctor':
      return router.push('/pages/doctor/requests');
    case 'patient':
      return router.push('/pages/patient/requests');
    default:
      return console.log('could not redirect');
  }
}

export default new Vuex.Store({
  state: {
    isBackButtonVisible: true,
    isAppBarVisible: !!localStorage.getItem('prontuario_token'),
    user: JSON.parse(localStorage.getItem('prontuario_user') || '{}'),
    token: localStorage.getItem('prontuario_token') || '',
    expires_in: null,
  },
  mutations: {
    SET_USER(state, payload) {
      state.user = payload.user;
    },
    SET_TOKEN(state, payload) {
      state.token = payload.token;
    },
    SET_EXPIRES_IN(state, payload) {
      state.expires_in = payload.expires_in;
    },
    SET_APP_BAR_VISIBILITY(state, payload) {
      state.isAppBarVisible = payload.visibility;
    },
    SET_ARROW_BACK_VISIBILITY(state, payload) {
      state.isBackButtonVisible = payload.visibility;
    },
  },
  actions: {
    SET_ARROW_BACK_VISIBILITY({ commit }, payload) {
      commit('SET_ARROW_BACK_VISIBILITY', payload);
    },
    login: async ({ commit }, payload) => {
      try {
        const response = await api.post('login', {
          cpf: payload.cpf,
          password: payload.password,
        });

        if (response.status === 200) {
          const { token, expires_in } = response.data;
  
          localStorage.setItem('prontuario_token', token);
          commit('SET_TOKEN', { token });
          commit('SET_EXPIRES_IN', { expires_in });
  
          api.defaults.headers.Authorization = `Bearer ${token}`;
  
          const { user } = response.data;
          localStorage.setItem('prontuario_user', JSON.stringify(user));
          commit('SET_USER', { user });

          redirects(user.user_type);

          commit('SET_APP_BAR_VISIBILITY', { visibility: true });
        }
      } catch(ex) {
        alert('Falha ao logar. Verifique seu CPF e senha!');
      }
    },

    logout: ({ commit }) => {
      localStorage.removeItem('prontuario_token');
      localStorage.removeItem('prontuario_user');
      commit('SET_TOKEN', '');
      commit('SET_EXPIRES_IN', 0);
      router.push('/');
      commit('SET_APP_BAR_VISIBILITY', { visibility: false });
    },

    async deleteAccount(context) {
      const user = context.state.user;
      const response = await api.delete(`/${user.user_type}s/${user.id}`);
      if(response.status === 200) {
        context.dispatch('logout');
      }
    }
  },
});
