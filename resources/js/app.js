import './bootstrap';
import { createApp } from 'vue';
import Example from './Components/Example.vue';
const app=createApp({
    components:{
        Example,
    }
});
app.mount("#app");