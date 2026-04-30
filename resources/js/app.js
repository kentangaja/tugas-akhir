import './bootstrap';
import Alpine from 'alpinejs';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css'; 

window.Alpine = Alpine;
Alpine.start();

NProgress.configure({ 
    minimum: 0.05,      
    easing: 'ease-in-out',     
    speed: 800,         
    showSpinner: false,
    trickleSpeed: 200,  
});

// Helper function to dispatch loading event
window.showLoading = (isLoading = true) => {
    window.dispatchEvent(new CustomEvent('loading', { 
        detail: { isLoading } 
    }));
};

// Setup axios interceptors for loading screen
window.axios.interceptors.request.use((config) => {
    window.showLoading(true);
    NProgress.start();
    return config;
}, (error) => {
    window.showLoading(false);
    NProgress.done();
    return Promise.reject(error);
});

window.axios.interceptors.response.use((response) => {
    NProgress.done();
    window.showLoading(false);
    return response;
}, (error) => {
    NProgress.done();
    window.showLoading(false);
    return Promise.reject(error);
});

// Show loading when page is about to unload
window.addEventListener('beforeunload', () => {
    window.showLoading(true);
});

window.addEventListener('load', () => {
    NProgress.done();
    window.showLoading(false);
});