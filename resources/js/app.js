import Vue from "vue";
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
const root = document.getElementById('app');
new Vue({
    render: h => h(
        Vue.component(root.dataset.component), {
            props: JSON.parse(root.dataset.props)
        }
    )
}).$mount(root);
