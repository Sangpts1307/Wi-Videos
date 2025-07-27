import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import BaseComponent from './components/BaseComponent.vue';
import ContentComponent from './components/ContentComponent.vue';
import ChatComponent from './components/ChatComponent.vue';

const app = createApp(App);
app.component('base-component', BaseComponent);
app.component('content-component', ContentComponent);
app.component('chat-component', ChatComponent);
app.mount('#app');