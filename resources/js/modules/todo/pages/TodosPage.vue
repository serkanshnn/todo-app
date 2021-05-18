<template>
    <div>
        <div v-for="todo in payload" v-if="payload.length > 0">Hello {{todo}}</div>
    </div>
</template>

<script>
import TodoStore from "../store/TodoStore";

export default {
    name: "TodosPage",
    data() {
        return {
            payload: []
        }
    },
    methods: {
        handleFetchTodos() {
            TodoStore.fetchAllTodos()
                .then((response) => {
                    this.payload = response.data.data
                })
                .catch(error => console.log(error));
        }
    },
    mounted() {
        this.handleFetchTodos();
    }
}
</script>

<style scoped>

</style>
