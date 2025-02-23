import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add request interceptor
let activeRequests = 0;

axios.interceptors.request.use(function (config) {
    activeRequests++;
    return config;
}, function (error) {
    activeRequests--;
    return Promise.reject(error);
});

// Add response interceptor
axios.interceptors.response.use(function (response) {
    activeRequests--;
    return response;
}, function (error) {
    activeRequests--;
    return Promise.reject(error);
});
