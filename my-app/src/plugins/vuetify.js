import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import '../sass/overrides.sass';

const theme = {
  primary: '#714cfe',
  secondary: '#4b0082',
  accent: '#ffff',
  info: '#00CAE3',
};

Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    themes: {
      dark: theme,
      light: theme,
    },
  },
});
