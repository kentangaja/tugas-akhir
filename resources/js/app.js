import './bootstrap';
import Alpine from 'alpinejs';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css'; 

window.Alpine = Alpine;
Alpine.start();

NProgress.configure({ 
    minimum: 0.1,       
    easing: 'ease',     
    speed: 500,         
    showSpinner: false,
});

window.addEventListener('beforeunload', () => {
    window.dispatchEvent(new Event('loading'));
});

window.addEventListener('load', () => {
    NProgress.done();
});