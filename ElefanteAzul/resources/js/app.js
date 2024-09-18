import './bootstrap';

window.axios = require('axios');
window.axios.defaults.baseURL = 'http://localhost/elefanteazul/public/api/';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
