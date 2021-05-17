import {createApp, h} from "vue";
import Home from "./pages/Home";

const root = document.getElementById('app');
const vue = createApp({
    render(){
        return h(vue.component(root.dataset.component), JSON.parse(root.dataset.props));
    }
});
vue.component('Home', Home);
vue.mount('#app');
