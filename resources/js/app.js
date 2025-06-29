import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import BaseComponent from './components/BaseComponent.vue';
const app = createApp(App);
// Declare paths to components that can be used in views.blade
app.component('base-component', BaseComponent);
app.mount('#app');