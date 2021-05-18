import * as TodoService from "../services/TodoService";
import Vue from "vue";

export default new Vue({
    methods: {
        async fetchAllTodos() {
            return await TodoService.all();
        },

        async fetchTodoDetail(todoId) {
            return await TodoService.detail(todoId);
        }
    }
});
