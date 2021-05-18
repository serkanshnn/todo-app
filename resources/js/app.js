import {createApp, h} from "vue";
import Home from "./pages/Home";
import TodosPage from "./modules/todo/pages/TodosPage";
import CreateTodoPage from "./modules/todo/pages/CreateTodoPage";

const root = document.getElementById('app');
const vue = createApp({
    render(){
        return h(vue.component(root.dataset.component), JSON.parse(root.dataset.props));
    }
});
vue.component('Home', Home);
vue.component('TodosPage', TodosPage);
vue.component('CreateTodoPage', CreateTodoPage);
vue.mount('#app');
