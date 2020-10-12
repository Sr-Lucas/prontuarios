import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      component: () => import('./views/Index'),
      children: [
        // SignIn
        {
          name: 'SignIn',
          path: '',
          component: () => import('./views/pages/Login'),
        },
        // Dashboard
        {
          name: 'Dashboard',
          path: 'pages/admin/dashboard',
          component: () => import('./views/pages/admin/Dashboard'),
        },
        // Admin Doctors List
        {
          name: 'DoctorsList',
          path: 'pages/admin/doctors',
          component: () => import('./views/pages/admin/DoctorList'),
        },
        {
          name: 'DoctorsForm',
          path: 'pages/admin/doctors/form',
          component: () => import('./views/pages/admin/DoctorForm'),
        },
        // Admin Patients List
        {
          name: 'PatientsList',
          path: 'pages/admin/patients',
          component: () => import('./views/pages/admin/PatientList'),
        },
        // Admin Patients form
        {
          name: 'PatientsForm',
          path: 'pages/admin/patients/form',
          component: () => import('./views/pages/admin/PatientForm'),
        },

        /**
         * Patient Routes
         */
        {
          name: 'PatientRequestList',
          path: 'pages/patient/requests',
          component: () => import('./views/pages/patient/RequestList'),
        },
        {
          name: 'PatientRequestDotorList',
          path: 'pages/patient/doctors',
          component: () => import('./views/pages/patient/DoctorList'),
        },
        {
          name: 'PatientRequestForm',
          path: 'pages/patient/requests/form',
          component: () => import('./views/pages/patient/RequestForm'),
        },

        /**
         * Doctor Routes
         */
        {
          name: 'DoctorRequestList',
          path: 'pages/doctor/requests',
          component: () => import('./views/pages/doctor/RequestList'),
        },
        {
          name: 'DoctorRequestForm',
          path: 'pages/doctor/requests/form',
          component: () => import('./views/pages/doctor/RequestForm'),
        },

        /**
         * User Pages
         */
        {
          name: 'DoctorUserPage',
          path: 'pages/doctor/userPage',
          component: () => import('./views/pages/doctor/UserPage'),
        },
        {
          name: 'PatientUserPage',
          path: 'pages/patient/userPage',
          component: () => import('./views/pages/patient/UserPage'),
        },
        {
          name: 'AdministratorUserPage',
          path: 'pages/administrator/userPage',
          component: () => import('./views/pages/admin/UserPage'),
        },
      ],
    }
  ],
});