<template>

</template>

<script>
import TodoStore from "../store/TodoStore";

export default {
    name: "TodosPage",
    setup() {
        const todos = TodoStore.fetchAllTodos()
            .then(() => {})
            .catch((e) => { console.log(e);})
            .finally(() => {});
        console.log(todos);
    }
}
</script>

<style scoped>

</style>
