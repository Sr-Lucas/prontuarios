import axios from 'axios';

const api = axios.create({
  // node51851-deploy-backed.jelastic.saveincloud.net
  baseURL: 'http://localhost:8000/api',
  headers: {
    Authorization: `Bearer ${localStorage.getItem('prontuario_token')}`,
  },
});

export default api;
