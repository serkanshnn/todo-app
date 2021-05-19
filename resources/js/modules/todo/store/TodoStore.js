import * as TodoService from "../services/TodoService";
import Vue from "vue";
import {deleteTodo} from "../services/TodoService";

export default new Vue({
    methods: {
        async fetchAllTodos() {
            return await TodoService.all();
        },

        async fetchTodoDetail(todoId) {
            return await TodoService.detail(todoId);
        },

        async createTodo(params) {
            return await TodoService.create(params);
        },

        async deleteTodo(todoId) {
            return await TodoService.destroy(todoId);
        },

        async updateTodo(id, params) {
            return await TodoService.update(id, params);
        },

        async checkOrUncheck(todoId) {
            return await TodoService.checkOrUncheck(todoId);
        }
    }
});
