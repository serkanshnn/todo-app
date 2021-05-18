import {createApp} from "vue";
import * as TodoService from "../services/TodoService";

export default createApp({
    setup() {
        async function fetchAllTodos() {
            return await TodoService.all();
        }

        async function fetchTodoDetail(todoId) {
            return await TodoService.detail(todoId);
        }
        return {fetchAllTodos, fetchTodoDetail};
    }
});
